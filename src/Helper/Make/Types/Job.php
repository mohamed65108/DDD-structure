<?php

namespace Majal\DDD\Helper\Make\Types;

use Majal\DDD\Helper\FileCreator;
use Majal\DDD\Helper\Make\Maker;
use Majal\DDD\Helper\NamespaceCreator;
use Majal\DDD\Helper\Naming;
use Majal\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Job extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain'
    ];

    /**
     * Return options that should be treated as choices 
     *
     * @return Array
     */
    public $allowChoices = [
        'domain'
    ];

    /**
     * Check if the current options is True/False question
     *
     * @return Array
     */
    public $booleanOptions = [];

    /**
     * Check if the current options is requesd based on other option
     *
     * @return Array
     */
    public $requiredUnless = [];

    /**
     * Fill all placeholders in the stub file
     *
     * @param array $values
     * @return boolean
     */
    public function service(Array $values = []) : bool {
        
        $name = Naming::class($values['name']);

        $placeholders = [ 
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
        ];

        $dir = Path::toDomain($values['domain'],'Jobs');

        $content = Str::of($this->getStub('job'))
                        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($dir,$name,'php',$content);
        
        return true;
    }

}
