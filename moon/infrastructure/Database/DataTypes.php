<?php

namespace Moon\infrastructure\Database;

enum DataTypes {
    case Int;
    case Double;
    case Char;
    case VarChar;
    case Bool;
    case DateTime;
}