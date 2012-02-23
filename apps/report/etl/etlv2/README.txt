Openbiz Report ETL V2

How to run the sample ETL job

1. Unzip etl to cubi/bin/
2. Copy cubi/bin/etl/etl_runner.php to cubi/bin/tools
3. Edit cubi/bin/etl/jobs/etl_jobs_sample.xml
   Replace Source="C:/xampp/htdocs/gcubi/cubi/bin/etl/logs/apache_sample.log.20070410" to the right file path
4. Run sample ETL job
   # php etl_runner.php "jobs/etl_jobs_sample.xml" queue1
   
=================================================================
Expected output of processing each line of the sample log file
=================================================================
--- Step 1: extract ---
Array
(
    [client_ip] => 217.0.22.3
    [request_date] => 10/Apr/2007:10:58:45 +0300
    [protocol] => GET
    [uri] => /talks/Fundamentals/read-excel-file.html
    [status_code] => 404
    [bytes] => 311
    [user_agent] => Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.3) Gecko/20061201 Firefox/2.0.0.3 (Ubuntu-feisty)
)
--- Step 2: transform ---
Array
(
    [client_ip] => 217.0.22.3
    [request_date] => 10/Apr/2007:10:58:45 +0300
    [protocol] => GET
    [uri] => /talks/Fundamentals/read-excel-file.html
    [status_code] => 404
    [bytes] => 311
    [user_agent] => Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.3) Gecko/20061201 Firefox/2.0.0.3 (Ubuntu-feisty)
    [user_agent_cap] => MOZILLA/5.0 (X11; U; LINUX I686; EN-US; RV:1.8.1.3) GECKO/20061201 FIREFOX/2.0.0.3 (UBUNTU-FEISTY)
)
--- Step 3: load ---
insert sql > INSERT INTO access_log (`client_ip`,`request_date`,`protocol`,`uri`,`status_code`,`bytes`,`user_agent`) VALUES ('217.0.22.3','10/Apr/2007:10:58:45 +0300','GET','/talks/Fundamentals/read-excel-file.html','404','311','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.3) Gecko/20061201 Firefox/2.0.0.3 (Ubuntu-feisty)')
