# linode-bundle
Linode API 4

[![SymfonyInsight](https://insight.symfony.com/projects/8172742f-588b-4891-84ad-ff737bf24a69/big.svg)](https://insight.symfony.com/projects/8172742f-588b-4891-84ad-ff737bf24a69)


## Basic procedure to restore Linode from latest backup of another Linode

- `bin/console linode:instances:list` - to get linode id which last backup you want to use to create new linode
- `bin/console linode:instances:create-by-last-backup {linode_id}` - creates new linode from the backup, turns off first Linode, swaps IPs between first and second Linodes and turns on second Linode