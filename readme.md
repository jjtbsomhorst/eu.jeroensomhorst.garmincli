# GarminCli command

This little repo contains a little symfony cli command that can be used to 
export certain things from Garmin Connect. The package uses the dawguk/php-garmin-connect
package and an extended version of this (created by me). 

The can be used as followes: 

php bin/console garminexportcommand <username> <password>

next there will be some questions to answer

- Please specify working directory 
- Which format to be used (fit, kml, gpx, tcx )
- What to export ( activities, segments)
 
after this the command will try to login into garmin connect and to export the things specified. 

**use this at your own risk**
