<?php


class Farm {

    public function __construct() {
        $this->barn = array();
        $this->crop = array();
    }

    public function showBarnAnimals() {
        print_r("Животных в хлеву:<br/>");
        foreach ($this->barn as $animal => $animalArray) {
            $count = count($animalArray);
            print_r("${animal}: ${count}<br/>");
        }
        print_r("<br/>");
    }

    public function addAnimal($animalType, $animalObject) {
        if ( array_key_exists($animalType, $this->barn) ) {
            array_push($this->barn[$animalType], $animalObject);
        } else {
            $this->barn += array($animalType => array($animalObject));
        }
    }

    public function collectAllCrop($period) { // period: day, week, month (30 days)
        print_r("Crop for ${period}:<br/>");
        if (strtolower($period) == 'day') {
            $days = 1;
        } else if (strtolower($period) == 'week') {
            $days = 7;
        } else if (strtolower($period) == 'month') {
            $days = 30;
        } 

        
        foreach ($this->barn as $animal => $animalArray) {
            $count = count($animalArray);
            $quantity = 0;
            $cropType = $animalArray[0]->getCropType();
            for ($i = 0; $i < $count; $i++) {
                for ($j = 0; $j < $days; $j++) {
                    $quantity += $animalArray[$i]->collectCrop();
                }
            }
            print_r("${cropType}: ${quantity}<br/>");
        }
        print_r("<br/><br/>");
    }
}

class Animal {
    public $type; // cow, chicken
    public $productsNumber;

    public function __construct() {
        $this->id = uniqid();
    }

    public function showID() {
        echo($this->id);
    }

    public function getCropType() {
        return $this->cropType;
    }

}

class Cow extends Animal {
    public $cropType = 'milk';

    public function collectCrop() {
        $quantity = rand(8, 12);
        return $quantity;
    }
}

class Chicken extends Animal {
    public $cropType = 'eggs';

    public function collectCrop() {
        $quantity = rand(0, 1);
        return $quantity;
    }
}

// ========================================================================

// создать ферму
$farm = new Farm();

// 10 коров в хлев
for ($i = 0; $i < 10; $i++) {
    $farm->addAnimal('cow', new Cow());
}

// 20 кур в хлев
for ($i = 0; $i < 20; $i++) {
    $farm->addAnimal('chicken', new Chicken());
}

// 
$farm->showBarnAnimals();

//       количество урожая за неделю
$farm->collectAllCrop('week');

// добавляем ещё 5 кур в хлев
for ($i = 0; $i < 5; $i++) {
    $farm->addAnimal('chicken', new Chicken());
}

// добавляем ещё 1 корову в хлев
$farm->addAnimal('cow', new Cow());

// снова отображаем всех животных в хлеву
$farm->showBarnAnimals();

// снова отображаем количество урожая за неделю
$farm->collectAllCrop('week');
