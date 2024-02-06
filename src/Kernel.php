<?php

namespace PocketShares;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getCacheDir(): string
    {
        return '/home/parallels/docker/symfony/' . $this->getProjectDir().'/var/cache/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return '/home/parallels/docker/symfony/' . $this->getProjectDir().'/var/log/'.$this->environment;
    }
}
