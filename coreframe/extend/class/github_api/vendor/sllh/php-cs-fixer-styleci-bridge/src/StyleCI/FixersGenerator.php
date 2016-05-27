<?php

namespace SLLH\StyleCIBridge\StyleCI;

use Symfony\CS\Tokenizer\Token;
use Symfony\CS\Tokenizer\Tokens;

@trigger_error('The '.__NAMESPACE__.'\FixersGenerator class is deprecated since 1.4 and will be removed in 2.0.', E_USER_DEPRECATED);

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @deprecated since 1.4, will be removed in 2.0.
 */
final class FixersGenerator
{
    const STYLE_CI_CLASS_FILE = 'https://github.com/StyleCI/Config/raw/master/src/Config.php';

    /**
     * @var array
     */
    private $fixersTab = array();

    /**
     * Generate Fixers.php file.
     */
    public function generate()
    {
        file_put_contents(__DIR__.'/../StyleCI/Fixers.php', $this->getFixersClass());
    }

    /**
     * Generate Fixers.php content.
     *
     * @return string
     */
    public function getFixersClass()
    {
        $twig = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__.'/..'));

        $fixersTab = $this->getFixersTab();
        $presets = array();
        foreach ($fixersTab as $group => $fixers) {
            if (strstr($group, '_fixers')) {
                array_push($presets, str_replace('_fixers', '', $group));
            }
        }

        return $twig->render('StyleCI/Fixers.php.twig', array('fixersTab' => $fixersTab, 'presets' => $presets));
    }

    /**
     * Returns fixers tab from StyleCI Config ckass.
     *
     * @return array
     */
    public function getFixersTab()
    {
        $this->makeFixersTab();

        return $this->fixersTab;
    }

    private function makeFixersTab()
    {
        $configClass = file_get_contents('https://github.com/StyleCI/Config/raw/master/src/Config.php');

        /** @var Tokens|Token[] $tokens */
        $tokens = Tokens::fromCode($configClass);
        /*
         * @var int
         * @var Token
         */
        foreach ($tokens->findGivenKind(T_CONST) as $index => $token) {
            if ('[' === $tokens[$index + 6]->getContent()) {
                $name = strtolower($tokens[$index + 2]->getContent());
                $fixers = array();
                for ($i = $index + 7; ']' !== $tokens[$i]->getContent(); ++$i) {
                    if ($tokens[$i]->isGivenKind(T_CONSTANT_ENCAPSED_STRING) && ',' === $tokens[$i + 1]->getContent()) {
                        // Simple array management
                        array_push($fixers, array('name' => $this->getString($tokens[$i]->getContent())));
                    } elseif ($tokens[$i]->isGivenKind(T_CONSTANT_ENCAPSED_STRING)) {
                        // Double arrow management
                        $key = $this->getString($tokens[$i]->getContent());
                        for (++$i; $tokens[$i]->isGivenKind(T_DOUBLE_ARROW); ++$i) {
                        }
                        $i += 3;
                        array_push($fixers, array(
                            'key'  => $key,
                            'name' => $this->getString($tokens[$i]->getContent()),
                        ));
                    }
                }
                $this->fixersTab[$name] = $fixers;
            }
        }
    }

    /**
     * @param string $tokenContent
     *
     * @return string
     */
    private function getString($tokenContent)
    {
        return str_replace(array('"', "'"), '', $tokenContent);
    }
}
