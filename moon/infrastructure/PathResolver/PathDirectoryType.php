<?php

namespace Moon\infrastructure\PathResolver;

enum PathDirectoryType {
    case Config;
    case Public;
    case Local;
    case Kernel;
}