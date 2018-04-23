<?php

declare(strict_types = 1);

/**
 * Write a class with methods that provides change directory (cd) function for an abstract file system.
Notes:
* Root path is '/'.
* Path separator is '/'.
* Parent directory is addressable as '..'.
* Directory names consist only of English alphabet letters (A-Z and a-z).
* The function should support both relative and absolute paths.
* The function will not be passed any invalid paths.
* Do not use built-in path-related functions.
For example:
$path = new Path('/a/b/c/d');
$path->cd('../x')
echo $path->getCurrentPath();
should display '/a/b/c/x'.
 */
class Path
{

    private $currentPath;

    function __construct(string $newPath = '/')
    {
        $this->setCurrentPath($newPath);
    }

    /**
     * Validate a string to be used as a path
     * @param string $newPath
     * @return string
     */
    protected function validate(string $newPath): string
    {
        $newPath = str_replace('\\', '/', $newPath);
        $newPath = preg_replace('/[^\/a-zA-Z\.]/', '', $newPath);
        $newPath = str_replace('/./', '/', $newPath);
        return $newPath;
    }

    /**
     * Setter for current path
     * @param type $newPath
     * @return \self
     */
    protected function setCurrentPath(string $newPath = '/'): self
    {
        $newPath = $this->validate($newPath);
        $this->currentPath = $newPath ?? '/';
        return $this;
    }

    /**
     * Getter for current path
     * @return string
     */
    protected function getCurrentPath(): string
    {
        return $this->currentPath;
    }

    /**
     * Change the current location folder
     * @param string $newPath
     * @return \self
     * @throws Exception
     */
    public function cd(string $newPath): self
    {
        $newPath = $this->validate($newPath);

        $newPathArr = explode('/', $newPath);
        if ($newPathArr[0] === null) {
            $oldPathArr = [];
        } else {
            $oldPathArr = explode('/', $this->getCurrentPath());
        }

        foreach ($newPathArr as $node) {
            if ($node === '..') {
                if (count($oldPathArr) <= 0) {
                    throw new Exception('Folder does not exists.');
                }
                array_pop($oldPathArr);
            } else {
                $oldPathArr[] = $node;
            }
        }

        $this->setCurrentPath(implode('/', $oldPathArr));

        return $this;
    }

}

$path = new Path('/a/b/c/d');
echo '\n<br />' . $path->cd('../x')->getCurrentPath();
