<?php

namespace Majal\DDD\Helper\Make\Service;

use Majal\DDD\Helper\ArrayFormatter;
use Illuminate\Support\Str;
use Majal\DDD\Helper\Make\Maker;
use Majal\DDD\Helper\Make\Service\NullMaker;
use Majal\DDD\Helper\Make\Types\Controller;
use Majal\DDD\Helper\Make\Types\DatabaseView;
use Majal\DDD\Helper\Make\Types\Datatable;
use Majal\DDD\Helper\Make\Types\Domain;
use Majal\DDD\Helper\Make\Types\Entity;
use Majal\DDD\Helper\Make\Types\Factory;
use Majal\DDD\Helper\Make\Types\Migration;
use Majal\DDD\Helper\Make\Types\Seeder;
use Majal\DDD\Helper\NamespaceCreator;
use Majal\DDD\Helper\Path;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class MakeFactory{

    /**
     * Holds the segments of namespace structure
     *
     * @var array
     */
    public static $namespace=[
        'Majal',
        'DDD',
        'Helper',
        'Make',
        'Types',
    ];

    /**
     * Create an instance of the Maker to create directories
     *
     * @param Illuminate\Console\Command $ci
     * @return Maker
     */
    public static function create(Command $ci) : Maker{

        $makers = ArrayFormatter::files(File::files(Path::helper('Make','Types')));

        $supported  = ArrayFormatter::lower($makers);

        $type    = Str::lower($ci->argument('type'));

        if(in_array($type,$supported)){
    
            $type = Str::ucfirst($type);

            $namespace = MakeFactory::$namespace;

            array_push($namespace,$type);

            $class = NamespaceCreator::segments(...$namespace);

            return new $class($ci);
        
        }else{
            return new NullMaker($ci);
        }

    }

    public static function defineAttributes(&$signature){

        $files = ArrayFormatter::files(File::files(Path::helper('Make','Types')));

        array_walk($files,function(&$class){
            $class = NamespaceCreator::Segments('Majal','DDD','Helper','Make','Types',$class);
        });

        $keys=[];

        foreach($files as $class){
            $keys=array_unique(array_merge($keys,$class::getSignature()));
        }
        
        $keys = ArrayFormatter::wrap(ArrayFormatter::trim($keys,'_'),'{--','}');
        
        $join = implode(' ',$keys);
        
        $signature.=" ".$join;
    }

}