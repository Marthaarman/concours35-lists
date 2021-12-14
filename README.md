# concours35-lists

The program which can be found on concours35.nl is used for the equippe sporting section in the Netherlands.
This software has tools amongst one specific called 'monitor'. The monitor tool can output .dat files containing either information about starts or information about results.
These files I'll refer to as lists. 

This php-based tool concours35-lists is used to extract data and present it in a graphically interesting and easy way. 
For all kinds of pages, QR codes can easily be extracted which can be shared publically. 
With these QR codes direct links to pages with information about the lists or list contents can easily be shared. 

## landing page
index.php is the landing page. This page offers direct access to all the lists present. One can directly access a list or add a filter to either show lists with starts or results. 

## Upload files / lists
To upload the files or lists, one needs to upload the .dat files to a weblocation where the source code files are located, but into the files folder. 
You could use an FTP synchronizer for this task and allow the monitor program to automatically create the .dat files which then automates the whole process. 

## Disclaimer
These lists contain information about participants of the sporting event. Beware of publically broadcasting this kind of information. I'll hold no responsibility.
