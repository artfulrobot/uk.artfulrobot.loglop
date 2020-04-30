# Log Lop CiviCRM extension

## DEPRECATED! You (probably) don't need this!

Turns out that there's already a clean up job built into CiviCRM core which can delete job log records.

It has some weird logic but intends to (a) keep all logs for 30 days, and (b) deletes older logs (randomly) if they're older than 30 days.

You just need to enable the Scheduled Job called "cleanup".


## Original text:

Whenever CiviCRM runs scheduled jobs it creates entries in a logging table.
These are not very interesting and over time they build up enormously.

This extension will ensure your `civicrm_job_log` table stays trim by lopping
off entries older than a cut-off you specify.

I wrote it because I found that this table was the biggest in my database, which
was making backups slow and generally being a waste of resources.

## Installation

Install and enable the extension in the normal way. Then navigate to
`/civicrm/admin/loglop` which is where you say at what age you want to lop your
logs. **It defaults to 2 years**.

## See also

The following extension provides a way to limit the log *files* that can build up over time, too:
https://lab.civicrm.org/extensions/purgelogs
