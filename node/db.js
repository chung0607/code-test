var mongo = require('mongodb'),
    mongo_client = mongo.MongoClient,
    mongo_host = 'some.db.host',
    mongo_client = mongo.MongoClient,
    collection_name = 'challenge',
    db_connection;

/**
 * Read ALL data from mongo
 * @param collection
 * @param callback
 */
var read = function(collection, callback) {
    collection.find({}).toArray(function(err, docs) {
        console.log(docs);
        callback(docs);
    });
};

/**
 * Remove ALL data from mongo
 * @param collection
 * @param callback
 */
var clear = function(collection, callback) {
    collection.remove({}, function() {
        callback();
    });
};

/**
 * Connect to mongo
 * @param callback
 */
var connect = function(callback) {
    mongo_client.connect(mongo_host, function(err, db) {
        if (err) {
            throw err;
        }

        db_connection = db;
        collection = db_connection.collection(collection_name);

        callback(collection);
    });
};

if (process.argv[2] != 'read' && process.argv[2] != 'clear') {
    console.log('Error: Invalid argument. Please try\n\tnode db.js read\n\tnode db.js clear');
}
else {
    connect(function(collection) {
        var disconnect = function() {
            db_connection.close();
        };

        if (process.argv[2] == 'read') {
            read(collection, disconnect);
        }
        else if (process.argv[2] == 'clear') {
            clear(collection, disconnect);
        }
    });
}
