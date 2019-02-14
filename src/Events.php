<?php

namespace TheRat\LinodeBundle;

final class Events
{
    const preCreateByLastBackup = 'preCreateByLastBackup';
    const postCreateByLastBackup = 'postCreateByLastBackup';
    const preLinodeBoot = 'preLinodeBoot';
    const postLinodeBoot = 'postLinodeBoot';
    const preSwapIpv4 = 'preSwapIpv4';
    const postSwapIpv4 = 'postSwapIpv4';

    /**
     * Private constructor. This class is not meant to be instantiated.
     */
    private function __construct()
    {
    }
}