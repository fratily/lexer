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
class Manager{

    /**
     * @var Rule[]
     */
    private $rules  = [];

    /**
     * 字句解析器を生成する
     *
     * @return  Lexer
     */
    public function generateLexer(){
        return new Lexer($this);
    }

    /**
     * 設定されているルールのリストを取得する
     *
     * @return  Rule[]
     */
    public function getRules(){
        return $this->rules;
    }

    /**
     * ルールインスタンスを追加する
     *
     * @param   Rule    $rule
     *
     * @return  $this
     */
    public function addRule(Rule $rule){
        $this->rules[]  = $rule;

        return $this;
    }

    /**
     * 固定文字でルールを追加
     *
     * @param   string  $match
     *      一致する文字列を指定する。
     * @param   mixed   $token  [optional]
     *      トークン識別子を指定する。nullが指定された場合はスキップされる。
     * @param   int $priority   [optional]
     *      ルールの優先度を指定する。複数のルールが同時に一致した場合に、
     *      最も優先度の高いルールが適用される。ただし優先度も同じ場合は最も
     *      一致文字列長が長いものが適用される。
     *
     * @return  $this
     */
    public function addFixedRule(string $match, $token = null, int $priority = 0){
        return $this->addRule(new FixedRule($match, $token, $priority));
    }

    /**
     * 正規表現でルールを追加
     *
     * @param   string $regex
     *      正規表現構文を指定する。デリミタおよび先頭一致は内部的に付与される。
     * @param   mixed  $token   [optional]
     *      トークン識別子を指定する。nullが指定された場合はスキップされる。
     * @param   int $priority   [optional]
     *      ルールの優先度を指定する。複数のルールが同時に一致した場合に、
     *      最も優先度の高いルールが適用される。ただし優先度も同じ場合は最も
     *      一致文字列長が長いものが適用される。
     * @param   string  $delimiter  [optional]
     *      正規表現のデリミタ文字を指定する
     *
     * @return  $this
     */
    public function addRegexRule(string $regex, $token = null, int $priority = 0, string $delimiter = "/"){
        return $this->addRule(new RegexRule($regex, $token, $priority, [
            "regex.delimiter"   => $delimiter
        ]));
    }
}