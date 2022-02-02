<?php
declare(strict_types=1);

namespace Grsu\ApiKeyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('api_keys');
        $root = $treeBuilder->getRootNode();
        $root->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('users')
                    ->addDefaultsIfNotSet()
                    ->cannotBeOverwritten()
                    ->example([
                        'user_name' => 'api_admin',
                        'roles' => ['ROLE_ADMIN', 'ROLE_USER'],
                        'api_key' => 'qwerty123',
                        'ips' => ['127.0.0.1']
                    ])
                    ->children()
                        ->scalarNode('user_name')
                            ->defaultValue('api_admin')
                        ->end()
                        ->arrayNode('roles')
                            ->addDefaultsIfNotSet()
                            ->prototype('scalar')
                            ->defaultValue(['ROLE_ADMIN', 'ROLE_USER'])
                        ->end()
                        ->scalarNode('api_key')
                            ->defaultValue('qwerty123')
                        ->end()
                        ->arrayNode('ips')
                            ->canBeUnset()
                            ->prototype('scalar')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}