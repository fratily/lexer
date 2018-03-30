<?php
/**
 * FratilyPHP Lexer
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Kento Oka <kento.oka@kentoka.com>
 * @copyright   (c) Kento Oka
 * @license     MIT
 * @since       1.0.0
 */
namespace Fratily\Lexer;

/**
 *
 */
class RegexRule extends Rule{

    private $regex;

    /**
     * {@inheritdoc}
     */
    public function matchedLength(string $string): int{
        if($this->regex === null){
            $this->regex    = $this->createRegex();
        }

        $match  = preg_match($this->regex, $string,$m);

        if($match === false){
            throw new \Exception($this->regex);
        }

        if(isset($m[1])){
            return mb_strlen($m[1]);
        }

        return 0;
    }

    /**
     * 正規表現を組み立てる
     *
     * @return  string
     */
    private function createRegex(){
        $delimiter  = $this->getOption("regex.delimiter") ?? "/";

        if(strlen($delimiter) !== 1 || $delimiter === "\\"){
            throw new \Exception();
        }

        return sprintf("%s\A(%s)%s",
            $delimiter,
            $this->getMatch(),
            $delimiter,
            $this->getOption("regex.modifiers") ?? ""
        );
    }
}