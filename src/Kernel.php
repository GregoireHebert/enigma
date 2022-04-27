<?php

namespace App;

use App\Domain\Blog\ArticleDataSource\ArticleDataSource;
use App\Domain\Blog\ArticleDataSource\ArticleDataSourceInterface;
use App\Infra\Blog\DependencyInjection\CompilerPass\ArticleDataSourcePass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container)
    {
//        $container->registerForAutoconfiguration(ArticleDataSourceInterface::class)
//            ->addTag('app.article_data_source');
//
//        $container->addCompilerPass(new ArticleDataSourcePass());
    }
}
