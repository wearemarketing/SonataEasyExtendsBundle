<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\EasyExtendsBundle\Bundle;

use Symfony\Component\Finder\Finder;

class OrmMetadata
{
    /**
     * @var string
     */
    protected $mappingEntityDirectory;

    /**
     * @var string
     */
    protected $extendedMappingEntityDirectory;

    /**
     * @var string
     */
    protected $entityDirectory;

    /**
     * @var string
     */
    protected $extendedEntityDirectory;

    /**
     * @var string
     */
    protected $extendedSerializerDirectory;

    /**
     * @param BundleMetadata $bundleMetadata
     */
    public function __construct(BundleMetadata $bundleMetadata)
    {
        $this->mappingEntityDirectory = sprintf('%s/Resources/config/doctrine/', $bundleMetadata->getBundle()->getPath());
        $this->extendedMappingEntityDirectory = sprintf('%s/Resources/config/doctrine/', $bundleMetadata->getExtendedDirectory());
        $this->entityDirectory = sprintf('%s/Entity', $bundleMetadata->getBundle()->getPath());
        $this->extendedEntityDirectory = sprintf('%s/Entity', $bundleMetadata->getExtendedDirectory());
        $this->extendedSerializerDirectory = sprintf('%s/Resources/config/serializer', $bundleMetadata->getExtendedDirectory());
    }

    /**
     * @return string
     */
    public function getMappingEntityDirectory(): string
    {
        return $this->mappingEntityDirectory;
    }

    /**
     * @return string
     */
    public function getExtendedMappingEntityDirectory(): string
    {
        return $this->extendedMappingEntityDirectory;
    }

    /**
     * @return string
     */
    public function getEntityDirectory(): string
    {
        return $this->entityDirectory;
    }

    /**
     * @return string
     */
    public function getExtendedEntityDirectory(): string
    {
        return $this->extendedEntityDirectory;
    }

    /**
     * @return string
     */
    public function getExtendedSerializerDirectory(): string
    {
        return $this->extendedSerializerDirectory;
    }

    /**
     * @return array|\Iterator
     */
    public function getEntityMappingFiles(): iterable
    {
        try {
            $f = new Finder();
            $f->name('*.orm.xml.skeleton');
            $f->name('*.orm.yml.skeleton');
            $f->in($this->getMappingEntityDirectory());

            return $f->getIterator();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * @return array
     */
    public function getEntityNames(): array
    {
        $names = [];

        try {
            $f = new Finder();
            $f->name('*.orm.xml.skeleton');
            $f->name('*.orm.yml.skeleton');
            $f->in($this->getMappingEntityDirectory());

            foreach ($f->getIterator() as $file) {
                $name = explode('.', $file->getFilename());
                $names[] = $name[0];
            }
        } catch (\Exception $e) {
        }

        return $names;
    }

    /**
     * @return array|\Iterator
     */
    public function getRepositoryFiles(): iterable
    {
        try {
            $f = new Finder();
            $f->name('*Repository.php');
            $f->in($this->getEntityDirectory());

            return $f->getIterator();
        } catch (\Exception $e) {
            return [];
        }
    }
}
