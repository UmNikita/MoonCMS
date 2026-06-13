<?php

namespace Moon\infrastructure\Database\Migration;

enum SchemaTypes {
    case Id;
    case Int;
    case Double;
    case Char;
    case VarChar;
    case Bool;
    case DateTime;
}