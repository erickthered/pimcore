<?php
declare(strict_types=1);

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

namespace Pimcore\Bundle\StaticRoutesBundle\DependencyInjection;

use Pimcore\Config\LocationAwareConfigRepository;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class PimcoreStaticRoutesExtension extends ConfigurableExtension implements PrependExtensionInterface
{
    public function loadInternal(array $config, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../config')
        );

        $loader->load('services.yaml');

        $container->setParameter('pimcore_static_routes.definitions', $config['definitions']);
        $container->setParameter('pimcore_static_routes.config_location', $config['config_location'] ?? []);
    }

    public function prepend(ContainerBuilder $container): void
    {
        LocationAwareConfigRepository::loadSymfonyConfigFiles($container, 'pimcore_static_routes', 'staticroutes');
    }
}
