<?php

namespace Moon\infrastructure\Http\Route;

enum TypeRoute {
    case Success;
    case NotFound;
    case Error;
}