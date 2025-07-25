<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner;

use Exception;

/**
 * Exception thrown when a requested language class doesn't exist or doesn't implement LanguageInterface.
 */
final class LanguageNotExistsException extends Exception
{
}
