<?php

declare(strict_types = 1);

/**
 * Class PathTest
 * @covers Path
 */
final class PathTest extends \PHPUnit\Framework\TestCase
{

    private $oldPath;

    public function setUp(): void
    {
        parent::setUp();
        $this->oldPath = new Path('/a/b/c/d');
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->oldPath = null;
    }

    public function testCdRoot(): void
    {
        static::assertEquals('/', $this->oldPath->cd('/')->getCurrentPath());
    }

    public function testCdRoot2Down(): void
    {
        static::assertEquals('/hello/there', $this->oldPath->cd('/hello/there')->getCurrentPath());
    }

    public function testCd2Down(): void
    {
        static::assertEquals('/a/b/c/d/hello/there', $this->oldPath->cd('./hello/there')->getCurrentPath());
    }

    public function testCd1up1Down(): void
    {
        static::assertEquals('/a/b/c/x', $this->oldPath->cd('../x')->getCurrentPath());
    }

    public function testCd2up(): void
    {
        static::assertEquals('/a/b/x', $this->oldPath->cd('../../x')->getCurrentPath());
    }

    public function testCdBrokenup(): void
    {
        $this->expectException(Exception::class);
        $this->oldPath->cd('../../../../../x')->getCurrentPath();
    }

    public function testCd2DownBrokenSlashes(): void
    {
        static::assertEquals('/a/b/c/d/hello/there', $this->oldPath->cd('.\hello\there')->getCurrentPath());
    }

    public function testCd1up1DownCurrrentDot(): void
    {
        static::assertEquals('/a/b/c/x/y', $this->oldPath->cd('.././x/./y')->getCurrentPath());
    }

}
