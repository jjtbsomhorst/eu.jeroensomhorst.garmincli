# GarminCli command

This little repo contains a little symfony cli command that can be used to 
export certain things from Garmin Connect. The package uses the dawguk/php-garmin-connect
package and an extended version of this (created by me). 

***
**update 09-08-2021 **

Implementing setting functionality. Command will now ask for settings if now settings.json has been found. Next time 
the code runs it will read this file and ask if everything is ok. If so executes. Otherwhise asks for new settings



The can be used as followes: 

php bin/console garminexportcommand

next there will be some questions to answer (if there is no settings.json found)

- Please specify working directory 
- Which format to be used (fit, kml, gpx, tcx )
- What to export ( activities, segments)
 
after this the command will try to login into garmin connect and to export the things specified. 

**use this at your own risk**
