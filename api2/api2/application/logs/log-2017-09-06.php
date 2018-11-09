<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-09-06 15:05:11 --> Severity: Warning --> Invalid argument supplied for foreach() /usr/share/nginx/html/qmonline/application/views/adminlte/v_qaf_report.php 44
ERROR - 2017-09-06 15:05:13 --> Severity: Warning --> oci_execute(): ORA-00942: table or view does not exist /usr/share/nginx/html/qmonline/system/database/drivers/oci8/oci8_driver.php 286
ERROR - 2017-09-06 15:05:13 --> Query error: ORA-00942: table or view does not exist - Invalid query: SELECT *
FROM qaf_daily a
JOIN M_AREA b ON a.ID_AREA=b.ID_AREA
JOIN C_PARAMETER_ORDERS c ON a.ID_COMPONENT=c.ID_COMPONENT and b.ID_GROUPAREA=c.ID_GROUPAREA and c.DISPLAY='D'
WHERE a.BULAN = '9'
AND a.TAHUN = '2017'
AND a.ID_PRODUCT = '2'
AND a.ID_AREA = '1'
ORDER BY c.URUTAN ASC
ERROR - 2017-09-06 15:05:13 --> Severity: error --> Exception: Call to a member function result() on boolean /usr/share/nginx/html/qmonline/application/models/Qaf_daily.php 57
INFO - 2017-09-06 15:05:31 --> Config Class Initialized
INFO - 2017-09-06 15:05:31 --> Hooks Class Initialized
DEBUG - 2017-09-06 15:05:31 --> UTF-8 Support Enabled
INFO - 2017-09-06 15:05:31 --> Utf8 Class Initialized
INFO - 2017-09-06 15:05:31 --> URI Class Initialized
INFO - 2017-09-06 15:05:31 --> Router Class Initialized
INFO - 2017-09-06 15:05:31 --> Output Class Initialized
INFO - 2017-09-06 15:05:31 --> Security Class Initialized
DEBUG - 2017-09-06 15:05:31 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-09-06 15:05:31 --> Input Class Initialized
INFO - 2017-09-06 15:05:31 --> Language Class Initialized
INFO - 2017-09-06 15:05:31 --> Loader Class Initialized
INFO - 2017-09-06 15:05:31 --> Helper loaded: url_helper
INFO - 2017-09-06 15:05:31 --> Database Driver Class Initialized
DEBUG - 2017-09-06 15:05:31 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2017-09-06 15:05:31 --> Session: Class initialized using 'files' driver.
INFO - 2017-09-06 15:05:31 --> Controller Class Initialized
INFO - 2017-09-06 15:05:31 --> Model Class Initialized
INFO - 2017-09-06 15:05:31 --> Model Class Initialized
INFO - 2017-09-06 15:05:31 --> Model Class Initialized
INFO - 2017-09-06 15:05:31 --> Model Class Initialized
INFO - 2017-09-06 15:05:31 --> Final output sent to browser
DEBUG - 2017-09-06 15:05:31 --> Total execution time: 0.0443
INFO - 2017-09-06 15:05:31 --> Helper loaded: file_helper
INFO - 2017-09-06 15:05:31 --> Config Class Initialized
INFO - 2017-09-06 15:05:31 --> Hooks Class Initialized
DEBUG - 2017-09-06 15:05:31 --> UTF-8 Support Enabled
INFO - 2017-09-06 15:05:31 --> Utf8 Class Initialized
INFO - 2017-09-06 15:05:31 --> URI Class Initialized
INFO - 2017-09-06 15:05:31 --> Router Class Initialized
INFO - 2017-09-06 15:05:31 --> Output Class Initialized
INFO - 2017-09-06 15:05:31 --> Security Class Initialized
DEBUG - 2017-09-06 15:05:31 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-09-06 15:05:31 --> Input Class Initialized
INFO - 2017-09-06 15:05:31 --> Language Class Initialized
INFO - 2017-09-06 15:05:31 --> Loader Class Initialized
INFO - 2017-09-06 15:05:31 --> Helper loaded: url_helper
INFO - 2017-09-06 15:05:31 --> Database Driver Class Initialized
DEBUG - 2017-09-06 15:05:31 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2017-09-06 15:05:31 --> Session: Class initialized using 'files' driver.
INFO - 2017-09-06 15:05:31 --> Controller Class Initialized
INFO - 2017-09-06 15:05:31 --> Model Class Initialized
INFO - 2017-09-06 15:05:31 --> Model Class Initialized
INFO - 2017-09-06 15:05:31 --> Model Class Initialized
INFO - 2017-09-06 15:05:31 --> Model Class Initialized
INFO - 2017-09-06 15:05:31 --> Final output sent to browser
DEBUG - 2017-09-06 15:05:31 --> Total execution time: 0.0513
INFO - 2017-09-06 15:05:31 --> Helper loaded: file_helper
INFO - 2017-09-06 15:05:31 --> Config Class Initialized
INFO - 2017-09-06 15:05:31 --> Hooks Class Initialized
DEBUG - 2017-09-06 15:05:31 --> UTF-8 Support Enabled
INFO - 2017-09-06 15:05:31 --> Utf8 Class Initialized
INFO - 2017-09-06 15:05:31 --> URI Class Initialized
INFO - 2017-09-06 15:05:31 --> Router Class Initialized
INFO - 2017-09-06 15:05:31 --> Output Class Initialized
INFO - 2017-09-06 15:05:31 --> Security Class Initialized
DEBUG - 2017-09-06 15:05:31 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-09-06 15:05:31 --> Input Class Initialized
INFO - 2017-09-06 15:05:31 --> Language Class Initialized
INFO - 2017-09-06 15:05:31 --> Loader Class Initialized
INFO - 2017-09-06 15:05:31 --> Helper loaded: url_helper
INFO - 2017-09-06 15:05:31 --> Database Driver Class Initialized
DEBUG - 2017-09-06 15:05:31 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2017-09-06 15:05:31 --> Session: Class initialized using 'files' driver.
INFO - 2017-09-06 15:05:31 --> Controller Class Initialized
INFO - 2017-09-06 15:05:31 --> Model Class Initialized
INFO - 2017-09-06 15:05:31 --> Model Class Initialized
INFO - 2017-09-06 15:05:31 --> Model Class Initialized
INFO - 2017-09-06 15:05:31 --> Model Class Initialized
ERROR - 2017-09-06 15:05:31 --> Severity: Warning --> oci_execute(): ORA-00942: table or view does not exist /usr/share/nginx/html/qmonline/system/database/drivers/oci8/oci8_driver.php 286
ERROR - 2017-09-06 15:05:31 --> Query error: ORA-00942: table or view does not exist - Invalid query: SELECT *
FROM qaf_daily a
JOIN M_AREA b ON a.ID_AREA=b.ID_AREA
JOIN C_PARAMETER_ORDERS c ON a.ID_COMPONENT=c.ID_COMPONENT and b.ID_GROUPAREA=c.ID_GROUPAREA and c.DISPLAY='D'
WHERE a.BULAN = '9'
AND a.TAHUN = '2017'
AND a.ID_PRODUCT = '2'
AND a.ID_AREA = '1'
ORDER BY c.URUTAN ASC
ERROR - 2017-09-06 15:05:31 --> Severity: error --> Exception: Call to a member function result() on boolean /usr/share/nginx/html/qmonline/application/models/Qaf_daily.php 57
INFO - 2017-09-06 15:05:31 --> Helper loaded: file_helper
