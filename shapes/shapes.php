<?php

$shapes = getShapes();

echo "List (1):\n";
foreach ($shapes as $shape) {
    $shape->outputOne();
    echo "\n";
}

echo "List (2):\n";
$shapes = sortArea($shapes);
foreach ($shapes as $shape) {
    $shape->outputTwo();
    echo "\n";
}

echo "List (3):\n";
$shapes = sortDistance($shapes);
foreach ($shapes as $shape) {
    $shape->outputThree();
    echo "\n";
}


function getShapes() {
    $shapes = array();

    $fp = fopen('sample_input.csv', 'r');

    while (($line = fgets($fp)) !== false) {
        $lineArray = explode(',', $line);

        switch ($lineArray[0]) {
            case 'circle':
                $shape = new Circle($lineArray[1], $lineArray[2], $lineArray[3]);
                break;
            case 'rectangle':
                $shape = new Rectangle($lineArray[1], $lineArray[2], $lineArray[3], $lineArray[4]);
                break;
            case 'square':
                $shape = new Square($lineArray[1], $lineArray[2], $lineArray[3]);
                break;
        }

        $shapes[] = $shape;
    }
    fclose($fp);

    return $shapes;
}

function sortArea($shapes) {
    usort($shapes, function($a, $b) {
        return $a->getArea() < $b->getArea();
    });

    return $shapes;
}

function sortDistance($shapes) {
    usort($shapes, function($a, $b) {
        return $a->getDistance() < $b->getDistance();
    });

    return $shapes;
}


abstract class Shape {

    protected $_x;
    protected $_y;
    protected $_area;
    protected $_distance;
    protected $_isContainOrigin;
    

    public function __construct($x, $y) {
        $this->_x = $x;
        $this->_y = $y;

        $this->_area = $this->_calculateArea();
        $this->_distance = $this->_calculateDistance();
        $this->_isContainOrigin = $this->_getIsContainOrigin();
    }

    public function getArea() {
        return $this->_area;
    }

    public function getDistance() {
        return $this->_distance;
    }

    protected function _printNumber($value) {
        return number_format((float)$value, 3, '.', '');
    }

    /**
     * Get output (2)
     */
    public function outputTwo() {
        echo $this->outputOne() . ' and area ' . $this->_printNumber($this->_area);
    }

    /**
     * Get output (3)
     */
    public function outputThree() {
        if ($this->_isContainOrigin) {
            echo 'I\'m a ' . get_class($this) . ' containing the origin';
        }
        else {
            echo 'I\'m a ' . get_class($this) . ' ' . $this->_printNumber($this->_distance) . ' units away from the origin';
        }
    }

}


class Rectangle extends Shape {

    private $_width;
    private $_height;

    public function __construct($x, $y, $width, $height) {
        $this->_width = $width;
        $this->_height = $height;
        parent::__construct($x, $y);

    }

    /**
     * Calculate Area
     * @return float
     */
    protected function _calculateArea() {
        return $this->_width * $this->_height;
    }

    /**
     * Calculate Euclidean distance
     * @return float
     */
    protected function _calculateDistance() {
        // right
        if ($this->_x > 0) {
            // top
            if ($this->_y > 0) {
                return sqrt(pow($this->_x, 2) + pow($this->_y, 2));
            }
            else {
                // middle
                if ($this->_y + $this->_height > 0) {
                    return $this->_x;
                }
                // bottom
                else {
                    return sqrt(pow($this->_x, 2) + pow($this->_y + $this->_height, 2));
                }
            }
        }
        else {
            // middle
            if ($this->_x + $this->_width > 0) {
                // top
                if ($this->_y > 0) {
                    return $this->_y;
                }
                else {
                    // middle
                    if ($this->_y + $this->_height > 0) {
                        // containing, no this case here
                    }
                    // bottom
                    else {
                        return $this->_y + $this->_height;
                    }
                }
            }
            // left
            else {
                // top
                if ($this->_y > 0) {
                    return sqrt(pow($this->_x + $this->_width, 2) + pow($this->_y, 2));
                }
                else {
                    // middle
                    if ($this->_y + $this->_height > 0) {
                        return $this->_x + $this->_width;
                    }
                    // bottom
                    else {
                        return sqrt(pow($this->_x + $this->_width, 2) + pow($this->_y + $this->_height, 2));
                    }
                }
            }
        }
    }

    /**
     * Check if the shape containing origin
     * @return bool
     */
    protected function _getIsContainOrigin() {
        return $this->_x <= 0 && $this->_y <= 0 && $this->_x + $this->_width >= 0 && $this->_y + $this->_height >= 0;
    }


    /**
     * Get output (1)
     */
    public function outputOne() {
        echo 'I\'m a Rectangle with base ' . $this->_printNumber($this->_width) . ' and height ' . $this->_printNumber($this->_height);
    }

}

class Circle extends Shape {

    private $_radius;

    public function __construct($x, $y, $radius) {
        $this->_radius = $radius;
        parent::__construct($x, $y);

    }

    /**
     * Calculate Area
     * @return float
     */
    protected function _calculateArea() {
        return $this->_radius * $this->_radius * 3.14;
    }

    /**
     * Calculate Euclidean distance
     * @return float
     */
    protected function _calculateDistance() {
        return sqrt(pow($this->_x, 2) + pow($this->_y, 2)) - $this->_radius;
    }

    /**
     * Check if the shape containing origin
     * @return bool
     */
    protected function _getIsContainOrigin() {
        return $this->_calculateDistance() <= 0;
    }

    /**
     * Get output (1)
     */
    public function outputOne() {
        echo 'I\'m a Circle with radius ' . $this->_printNumber($this->_radius);
    }

}

class Square extends Shape {

    private $_side;

    public function __construct($x, $y, $side) {
        $this->_side = $side;
        parent::__construct($x, $y);
    }

    /**
     * Calculate Area
     * @return float
     */
    protected function _calculateArea() {
        return $this->_side * $this->_side;
    }

    /**
     * Calculate Euclidean distance
     * @return float
     */
    protected function _calculateDistance() {
        // right
        if ($this->_x > 0) {
            // top
            if ($this->_y > 0) {
                return sqrt(pow($this->_x, 2) + pow($this->_y, 2));
            }
            else {
                // middle
                if ($this->_y + $this->_side > 0) {
                    return $this->_x;
                }
                // bottom
                else {
                    return sqrt(pow($this->_x, 2) + pow($this->_y + $this->_side, 2));
                }
            }
        }
        else {
            // middle
            if ($this->_x + $this->_side > 0) {
                // top
                if ($this->_y > 0) {
                    return $this->_y;
                }
                else {
                    // middle
                    if ($this->_y + $this->_side > 0) {
                        // containing, no this case here
                    }
                    // bottom
                    else {
                        return $this->_y + $this->_side;
                    }
                }
            }
            // left
            else {
                // top
                if ($this->_y > 0) {
                    return sqrt(pow($this->_x + $this->_side, 2) + pow($this->_y, 2));
                }
                else {
                    // middle
                    if ($this->_y + $this->_side > 0) {
                        return $this->_x + $this->_side;
                    }
                    // bottom
                    else {
                        return sqrt(pow($this->_x + $this->_side, 2) + pow($this->_y + $this->_side, 2));
                    }
                }
            }
        }
    }

    /**
     * Check if the shape containing origin
     * @return bool
     */
    protected function _getIsContainOrigin() {
        return $this->_x <= 0 && $this->_y <= 0 && $this->_x + $this->_side >= 0 && $this->_y + $this->_side >= 0;
    }

    /**
     * Get output (1)
     */
    public function outputOne() {
        echo 'I\'m a Square with side ' . $this->_printNumber($this->_side);
    }

}