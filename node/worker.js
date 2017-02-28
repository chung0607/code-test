var counter = 10,
    fail_delay = 3,
    success_delay = 60,
    request = require('request'),
    fivebeans = require('fivebeans'),
    mongo = require('mongodb'),
    tube_name = 'chung0607',
    collection_name = 'challenge',
    fivebeans_client = new fivebeans.client('some.db.host', 11300),
    mongo_client = mongo.MongoClient,
    mongo_host = 'some.db.host',
    xe_url = 'http://www.xe.com/currencyconverter/convert/?Amount=1&r=',
    collection,
    db_connection;

/**
 * Main function
 */
var main = function() {
    prepareConnections(function() {
        doJob();
    });
};

/**
 * Connect to mongodb & beanstalkd
 * @param callback
 */
var prepareConnections = function (callback) {
    connectDb(function() {
        connectQueue(function () {
            //console.log('Connected');
            callback();
        });
    });
};

/**
 * Connect to the DB
 * @param callback
 */
var connectDb = function(callback) {
    mongo_client.connect(mongo_host, function(err, db) {
        if (err) {
            throw err;
        }

        db_connection = db;
        collection = db_connection.collection(collection_name);

        callback();
    });
};

/**
 * Connect to the queue
 * @param callback
 */
var connectQueue = function(callback) {
    fivebeans_client
        .on('connect', function() {
                fivebeans_client.use(tube_name, function() {
                    fivebeans_client.watch(tube_name, function(err, numwatched) {
                        callback();
                    });
                });
            })
        .on('error', function(err) {
                throw err;
            })
        .on('close', function() {
                //console.log('Closed! Bye!');
                db_connection.close();
            })
        .connect();
};

/**
 * Get job then work on it then respawn job
 */
var doJob = function() {
    consumeJob(function(err, output) {
        if (err) {
            //console.log('Buried invalid job');
            return doJob();
        }

        var is_success = (err === null);
        reputJob(output.job_id, output.payload, is_success, function() {
            //console.log('is_success: ' + is_success);
            if (is_success) {
                counter--;
                if (counter > 0) {
                    doJob();
                }
                else {
                    fivebeans_client.end();
                    return;
                }
            }
        });
    });
};

/**
 * Reserve a job
 * @param callback
 */
var reserveJob = function(callback) {
    fivebeans_client.reserve(function(err, job_id, payload) {
        if (err) {
            throw err;
        }

        callback(job_id, payload);
    });
};

/**
 * Work on a job
 * @param callback
 */
var consumeJob = function(callback) {
    reserveJob(function(job_id, payload) {
        var parsed = JSON.parse(payload.toString('ascii'));

        //console.log('reserved ' + job_id + ', payload: ' + payload);

        // I found someone is doing something bad in my tube... bury it!!!
        if (!parsed.from || !parsed.to) {
            fivebeans_client.bury(job_id, 1, function(err) {});
            return callback(new Error('Invalid job: ' + payload));
        }

        generateDbData(parsed.from, parsed.to, function(err, data) {
            var output = {
                job_id: job_id,
                payload: payload
            };

            if (err) {
                return callback(err, output);
            }

            insertDbData(data, function(err) {
                return callback(err, output);
            });
        });
    });
};

/**
 * Generate DB data to insert
 * @param from
 * @param to
 * @param callback
 */
var generateDbData = function(from, to, callback) {
    getRate(from, to, function(err, rate) {
        if (err) {
            return callback(err);
        }

        var data = {
            from: from,
            to: to,
            created_at: new Date(),
            rate: rate
        };

        callback(null, data);
    });
}

/**
 * Get exchange rate from website
 * @param from
 * @param to
 * @param callback
 */
var getRate = function(from, to, callback) {
    var options = {
        url: xe_url + '&From=' + from + '&To=' + to,
        headers: {
            'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language': 'en-US,en;q=0.8',
            'Connection': 'keep-alive',
            'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.99 Safari/537.36'
        }
    };

    // scrape the website
    request(options, function(err, response, body) {
        if (err) {
            return callback(err);
        }

        var rate;

        rate = body.match(/class="rightCol">([0-9\.]+)&nbsp;<span class="uccResCde"/)[1];
        rate = '' + Number(parseFloat(rate).toFixed(2));

        //console.log('Get rate: ' + rate);

        callback(null, rate);
    });
}

/**
 * Insert data to mongo
 * @param data
 * @param job_id
 * @param payload
 */
var insertDbData = function(data, callback) {
    collection.insert(data, function(err, docs) {
        //console.log('Inserted data: ' + JSON.stringify(data));
        return callback(err);
    });
};

/**
 * Destroy the job and create a new one to the queue
 * @param job_id
 * @param payload
 * @param is_success
 * @param callback
 */
var reputJob = function(job_id, payload, is_success, callback) {
    fivebeans_client.destroy(job_id, function(err) {
        //console.log('destroyed job: ' + job_id);

        var delay;

        if (is_success) {
            delay = success_delay;
        }
        else {
            delay = fail_delay;
        }

        fivebeans_client.put(1, delay, 10, payload, function(err, job_id) {
            //console.log('created job: ' + job_id);
            callback();
        });
    });
};

if (require.main === module) {
    main();
}