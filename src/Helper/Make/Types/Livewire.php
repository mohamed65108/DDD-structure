<?php

namespace Majal\DDD\Helper\Make\Types;

use Illuminate\Support\Str;
use Majal\DDD\Helper\Path;
use Majal\DDD\Helper\Naming;
use Majal\DDD\Helper\Make\Maker;

class Livewire extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
     *
     * @return Array
     */
    public $options = [
        'name',
    ];


    /**
     * Set Service
     *
     * @param Array $values
     * @return Bool
     */
    public function service(Array $values):Bool{

        $name = Naming::class($values['name']);

        $view = strtolower(Naming::class($values['name']));

        $placeholders = [ 
            '{{NAME}}' => $name,
            '{{NAME_LC}}' => $view,
        ];

        $destination = Path::toCommon('Http', 'Livewire');
        
        $content = Str::of($this->getStub('livewire'))->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$name,'php',$content);

        return true;
    }

}
