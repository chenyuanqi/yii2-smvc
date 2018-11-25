<?php

namespace common\enums;

class StatusEnum
{
    const DELETED = -1;
    const DISABLED = 0;
    const ENABLED = 1;
    public static $statusLabels = [
        self::DELETED => '已删除',
        self::DISABLED => '禁用',
        self::ENABLED => '启用',
    ];

    const AUDIT_REVIEWING = 0;
    const AUDIT_SUCCESS = 1;
    const AUDIT_FAILURE = 2;
    public static $auditStatusLabels = [
        self::AUDIT_REVIEWING => '待审核'，
        self::AUDIT_SUCCESS => '审核通过',
        self::AUDIT_FAILURE => '审核失败',
    ];
}
