<?php

namespace TheRat\LinodeBundle;

final class Events
{
    /**
     * Private constructor. This class is not meant to be instantiated.
     */
    private function __construct()
    {
    }

    const preCreateByLastBackup = 'preCreateByLastBackup';
    const postCreateByLastBackup = 'postCreateByLastBackup';

    const preLinodeBoot = 'preLinodeBoot';
    const postLinodeBoot = 'postLinodeBoot';

    const preSwapIpv4 = 'preSwapIpv4';
    const postSwapIpv4 = 'postSwapIpv4';
}