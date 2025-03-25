<?php

declare(strict_types=1);

namespace CwConnector\Domain\ErrorCodes;

/**
 * This class defines error codes specific to domain-related exceptions and validations.
 *
 * The constants included in this class provide standardized error codes for various errors that
 * might occur while performing operations related to entities such as a person, time entry,
 * time sheet, and batch processing in the domain.
 *
 * These error codes can be used to identify and handle specific errors in the application.
 */
class DomainErrorCodes
{
    public const int PERSON_ID_INVALID_DOCUMENT_TYPE = 100;
    public const int TIME_ENTRY_INVALID_DATE = 101;
    public const int TIME_ENTRY_INVALID_HOURS = 102;
    public const int TIME_ENTRY_INVALID_TIME_ENTRIES = 103;
    public const int TIME_SHEET_INVALID_TIME_SHEETS = 104;
    public const int BATCH_NOT_FOUND_EXCEPTION = 105;
    public const int BATCH_UNFINISHED_BATCH = 106;
    public const int BATCH_SEND_FAILED = 107;
    public const int BATCH_SEND_IN_BACKGROUND_FAILED = 108;
}