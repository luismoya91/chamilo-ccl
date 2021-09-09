<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\Tests\CoreBundle\Repository;

use Chamilo\CoreBundle\Entity\SysAnnouncement;
use Chamilo\CoreBundle\Repository\SysAnnouncementRepository;
use Chamilo\Tests\ChamiloTestTrait;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SysAnnouncementRepositoryTest extends WebTestCase
{
    use ChamiloTestTrait;

    /**
     * Class SysAnnouncementFixtures created one announcement during installation.
     */
    public function testWelcomeSysAnnouncement(): void
    {
        self::bootKernel();
        $repo = self::getContainer()->get(SysAnnouncementRepository::class);
        $count = $repo->count([]);

        $this->assertSame(1, $count);
    }

    public function testCreate(): void
    {
        self::bootKernel();
        $repo = self::getContainer()->get(SysAnnouncementRepository::class);
        $count = $repo->count([]);
        $this->assertSame(1, $count);

        $em = $this->getEntityManager();
        $sysAnnouncement = (new SysAnnouncement())
            ->setTitle('Welcome to Chamilo!')
            ->setContent('content')
            ->setUrl($this->getAccessUrl())
            ->setDateStart(new DateTime())
            ->setDateEnd(new DateTime('now +30 days'))
            ->addRole('ROLE_ANONYMOUS')
            ->addRole('ROLE_USER') // connected users
        ;
        $em->persist($sysAnnouncement);
        $em->flush();
        $count = $repo->count([]);
        $this->assertSame(2, $count);
    }
}