<?php

namespace Fibdesign\Ticket\enums;

enum StatusEnums:string
{
    case OPEN = 'باز';
    case CLOSED = 'بسته';
    case RESPONDED = 'پاسخ داده شده';
    case WAITING = 'پاسخ مشتری';
}
