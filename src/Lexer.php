<?php
/**
 * FratilyPHP Lexer
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Kento Oka <kento-oka@kentoka.com>
 * @copyright   (c) Kento Oka
 * @license     MIT
 * @since       1.0.0
 */
namespace Fratily\Lexer;

/**
 *
 */
class Lexer{

    /**
     * @var Manager
     */
    private $manager;

    public function __construct(Manager $manager){
        $this->manager  = $manager;
    }

    /**
     * 字句解析を実行する
     *
     * @param   string  $input
     *
     * @return  Token[]
     */
    public function exec(string $input){
        $length = mb_strlen($input);
        $result = [];
        $index  = 0;

        while($index < $length){
            $rules  = $this->manager->getRules();
            $match  = self::match($rules, mb_substr($input, $index));

            if($match === null){
                throw new \Exception(mb_substr($input, $index));
            }

            $index      = $index + $match["length"];

            if($match["rule"]->getToken() !== null){
                $result[]   = [
                    $match["rule"]->getToken(),
                    $match["matched"]
                ];
            }
        }

        return $result;
    }

    /**
     *
     * @param   Rule[]  $rules
     * @param   string  $string
     *
     * @return  mixed[]|null
     */
    public static function match(array $rules, string $string){
        $match  = [
            "rule"      => null,
            "matched"   => "",
            "length"    => -1
        ];

        foreach($rules as $rule){
            $tmpLen = $rule->matchedLength($string);

            if(0 < $tmpLen){
                if($match["rule"] === null
                    || $match["rule"]->getPriority() < $rule->getPriority()
                    || (
                        $match["rule"]->getPriority() === $rule->getPriority()
                        && $match["length"] < $tmpLen
                    )
                ){
                    $match["rule"]      = $rule;
                    $match["matched"]   = mb_substr($string, 0, $tmpLen);
                    $match["length"]    = $tmpLen;
                }
            }
        }

        if($match["rule"] === null){
            return null;
        }

        return $match;
    }
}