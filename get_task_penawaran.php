<?php 
###############################################################################################################
# Date          |    Type    |   Version                                                                      # 
############################################################################################################### 
# 22-09-2025    |   Create   |  1.3.2209.2025                                                                 #
# 20-10-2025    |   Modify   |  1.4.2010.2025                                                                 #
############################################################################################################### 

$server = $mssql_server;
$username = $mssql_user;  
$password = $mssql_pass;

$dsn = "sqlsrv:Server=$server;Database=WISE_STAGING";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Koneksi database gagal (FILE: " . __FILE__ . " LINE: " . __LINE__ . "): " . $e->getMessage());
    http_response_code(500);
    exit("Terjadi kesalahan sistem. Mohon coba lagi nanti.");
}


/* config mysql */ 
$conf_ip            = $mysql_server;  
$conf_user          = $mysql_user;
$conf_passwd        = $mysql_pass;
$conf_db            = $mysql_db;

function connectDB() {
    global $conf_ip, $conf_user, $conf_passwd, $conf_db, $pdo; // Tambahkan $pdo ke global

    $dsn = 'mysql:host=' . $conf_ip . ';dbname=' . $conf_db . ';charset=utf8mb4';
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $conf_user, $conf_passwd, $options);
        return true;
    } catch (\PDOException $e) {
        error_log("Koneksi database gagal: " . $e->getMessage());
        return false;
    }
}



function disconnectDB($db_connect) {
    $db_connect->close(); 
    unset($db_connect); 
}

$dateexe = DATE("Y-m-d H:i:s");
$dbopen  = connectDB();


    //top 100
    $no =1;
    $suc1=0;
    $err1=0;

$sqlflag = "UPDATE cc_ts_penawaran_job SET is_eligible_crm=0 WHERE SOURCE_DATA = 'WISE'";
$stmt = $dbopen->prepare($sqlflag);
$resflag = $stmt->execute();
$stmt->close();

$mss_1 = "select A.*
          FROM WISE_STAGING..V_MKT_POLO_ELIGIBLE A WITH(NOLOCK)
          LEFT JOIN (WISE_STAGING..T_MKT_POLO_ORDER_IN B WITH(NOLOCK)
                     LEFT JOIN WISE_STAGING..T_MKT_POLO_ORDER_IN_Y Y WITH(NOLOCK) ON B.T_MKT_POLO_ORDER_IN_ID = Y.T_MKT_POLO_ORDER_IN_ID)
          ON A.AGRMNT_NO = B.CONTRACT_NO
          AND ISNULL(Y.POLO_STEP, B.POLO_STEP) IN ('TASK MVS','TASK MSS', 'TASK MSS 2', 'TASK MSS AC', 'TASK WISE')
          WHERE A.IS_ACTIVE = '1' AND B.AGRMNT_NO IS NULL";

try {
    $stmt = $pdo->query($sql);
    
    while (($rcs_1 = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {

        $AGRMNT_ID = $rcs_1['AGRMNT_ID']; 
        $AGRMNT_NO = $rcs_1['AGRMNT_NO']; 
        $AGRMNT_DT = $rcs_1['AGRMNT_DT']; 
        $PIPELINE_ID = $rcs_1['PIPELINE_ID']; 
        $JOB_ID = $rcs_1['JOB_ID']; 
        $IS_ACTIVE = $rcs_1['IS_ACTIVE']; 
        $DISTRIBUTED_DT = $rcs_1['DISTRIBUTED_DT']; 
        $DISTRIBUTED_USR = $rcs_1['DISTRIBUTED_USR']; 
        $IS_COMPLETE = $rcs_1['IS_COMPLETE']; 
        $COMPLETED_DT = $rcs_1['COMPLETED_DT']; 
        $CAE_FINAL_SCORE = $rcs_1['CAE_FINAL_SCORE']; 
        $CAE_FINAL_RESULT = $rcs_1['CAE_FINAL_RESULT']; 
        $CAE_RESULT = $rcs_1['CAE_RESULT']; 
        $CAE_DT = $rcs_1['CAE_DT']; 
        $DUKCAPIL = $rcs_1['DUKCAPIL']; 
        $DUKCAPIL_RESULT = $rcs_1['DUKCAPIL_RESULT']; 
        $DUKCAPIL_API_DT = $rcs_1['DUKCAPIL_API_DT']; 
        $SCHEME_ID = $rcs_1['SCHEME_ID']; 
        $SLIK_CBASID = $rcs_1['SLIK_CBASID']; 
        $SLIK_RESULT = $rcs_1['SLIK_RESULT']; 
        $SLIK_CATEGORY = $rcs_1['SLIK_CATEGORY']; 
        $SLIK_API_DT = $rcs_1['SLIK_API_DT']; 
        $SOURCE_DATA = $rcs_1['SOURCE_DATA']; 
        $KILAT_PINTAR = $rcs_1['KILAT_PINTAR']; 
        $BUSINESS_DATE = $rcs_1['BUSINESS_DATE']; 
        $OFFICE_REGION_CODE = $rcs_1['OFFICE_REGION_CODE']; 
        $OFFICE_REGION_NAME = $rcs_1['OFFICE_REGION_NAME']; 
        $OFFICE_CODE = $rcs_1['OFFICE_CODE']; 
        $OFFICE_NAME = $rcs_1['OFFICE_NAME']; 
        $CAB_COLL = $rcs_1['CAB_COLL']; 
        $CAB_COLL_NAME = $rcs_1['CAB_COLL_NAME']; 
        $KAPOS_NAME = $rcs_1['KAPOS_NAME']; 
        $PROD_OFFERING_CODE = $rcs_1['PROD_OFFERING_CODE']; 
        $LOB_CODE = $rcs_1['LOB_CODE']; 
        $CUST_TYPE = $rcs_1['CUST_TYPE']; 
        $CUST_NO = $rcs_1['CUST_NO']; 
        $CUST_NAME = $rcs_1['CUST_NAME']; 
        $ID_NO = $rcs_1['ID_NO']; 
        $GENDER = $rcs_1['GENDER']; 
        $RELIGION = $rcs_1['RELIGION']; 
        $BIRTH_PLACE = $rcs_1['BIRTH_PLACE']; 
        $BIRTH_DT = $rcs_1['BIRTH_DT']; 
        $BIRTH_DT = date("Y-m-d h:i:s", strtotime($BIRTH_DT));
        $SPOUSE_ID_NO = $rcs_1['SPOUSE_ID_NO']; 
        $SPOUSE_NAME = $rcs_1['SPOUSE_NAME']; 
        $SPOUSE_BIRTH_DT = $rcs_1['SPOUSE_BIRTH_DT']; 
        $ADDR_LEG = $rcs_1['ADDR_LEG']; 
        $RT_LEG = $rcs_1['RT_LEG']; 
        $RW_LEG = $rcs_1['RW_LEG']; 
        $PROVINSI_LEG = $rcs_1['PROVINSI_LEG']; 
        $CITY_LEG = $rcs_1['CITY_LEG']; 
        $KABUPATEN_LEG = $rcs_1['KABUPATEN_LEG']; 
        $KECAMATAN_LEG = $rcs_1['KECAMATAN_LEG']; 
        $KELURAHAN_LEG = $rcs_1['KELURAHAN_LEG']; 
        $ZIPCODE_LEG = $rcs_1['ZIPCODE_LEG']; 
        $SUB_ZIPCODE_LEG = $rcs_1['SUB_ZIPCODE_LEG']; 
        $ADDR_RES = $rcs_1['ADDR_RES']; 
        $RT_RES = $rcs_1['RT_RES']; 
        $RW_RES = $rcs_1['RW_RES']; 
        $PROVINSI_RES = $rcs_1['PROVINSI_RES']; 
        $CITY_RES = $rcs_1['CITY_RES']; 
        $KABUPATEN_RES = $rcs_1['KABUPATEN_RES']; 
        $KECAMATAN_RES = $rcs_1['KECAMATAN_RES']; 
        $KELURAHAN_RES = $rcs_1['KELURAHAN_RES']; 
        $ZIPCODE_RES = $rcs_1['ZIPCODE_RES']; 
        $SUB_ZIPCODE_RES = $rcs_1['SUB_ZIPCODE_RES']; 
        $MOBILE1 = $rcs_1['MOBILE1']; 
        $MOBILE2 = $rcs_1['MOBILE2']; 
        $PHONE1 = $rcs_1['PHONE1']; 
        $PHONE2 = $rcs_1['PHONE2']; 
        $OFFICE_PHONE1 = $rcs_1['OFFICE_PHONE1']; 
        $OFFICE_PHONE2 = $rcs_1['OFFICE_PHONE2']; 
        $PROFESSION_CODE = $rcs_1['PROFESSION_CODE']; 
        $PROFESSION_NAME = $rcs_1['PROFESSION_NAME']; 
        $PROFESSION_CATEGORY_CODE = $rcs_1['PROFESSION_CATEGORY_CODE']; 
        $PROFESSION_CATEGORY_NAME = $rcs_1['PROFESSION_CATEGORY_NAME']; 
        $JOB_POSITION = $rcs_1['JOB_POSITION']; 
        $JOB_STATUS = $rcs_1['JOB_STATUS']; 
        $INDUSTRY_TYPE_NAME = $rcs_1['INDUSTRY_TYPE_NAME']; 
        $OTHER_BIZ_NAME = $rcs_1['OTHER_BIZ_NAME']; 
        $MONTHLY_INCOME = $rcs_1['MONTHLY_INCOME']; 
        $MONTHLY_EXPENSE = $rcs_1['MONTHLY_EXPENSE']; 
        $MONTHLY_INSTALLMENT = $rcs_1['MONTHLY_INSTALLMENT']; 
        $DOWNPAYMENT = $rcs_1['DOWNPAYMENT']; 
        $PERCENT_DP = $rcs_1['PERCENT_DP']; 
        $PLAFOND = $rcs_1['PLAFOND']; 
        $CUST_RATING = $rcs_1['CUST_RATING']; 
        $SUPPL_NAME = $rcs_1['SUPPL_NAME']; 
        $SUPPL_CODE = $rcs_1['SUPPL_CODE']; 
        $MACHINE_NO = $rcs_1['MACHINE_NO']; 
        $CHASSIS_NO = $rcs_1['CHASSIS_NO']; 
        $PRODUCT_CATEGORY = $rcs_1['PRODUCT_CATEGORY']; 
        $ASSET_CATEGORY_CODE = $rcs_1['ASSET_CATEGORY_CODE']; 
        $ASSET_TYPE = $rcs_1['ASSET_TYPE']; 
        $ITEM_BRAND = $rcs_1['ITEM_BRAND']; 
        $ITEM_TYPE = $rcs_1['ITEM_TYPE']; 
        $ITEM_DESCRIPTION = $rcs_1['ITEM_DESCRIPTION']; 
        $ASSET_MODEL = $rcs_1['ASSET_MODEL']; 
        $OTR_PRICE = $rcs_1['OTR_PRICE']; 
        $ITEM_YEAR = $rcs_1['ITEM_YEAR']; 
        $OWNER_RELATIONSHIP = $rcs_1['OWNER_RELATIONSHIP']; 
        $BPKB_OWNERSHIP = $rcs_1['BPKB_OWNERSHIP']; 
        $AGRMNT_RATING = $rcs_1['AGRMNT_RATING']; 
        $CONTRACT_STAT = $rcs_1['CONTRACT_STAT']; 
        $INST_PAYED = $rcs_1['INST_PAYED']; 
        $NEXT_INST_NUM = $rcs_1['NEXT_INST_NUM']; 
        $NEXT_INST_DT = $rcs_1['NEXT_INST_DT']; 
        $OS_TENOR = $rcs_1['OS_TENOR']; 
        $TENOR = $rcs_1['TENOR']; 
        $RELEASE_DATE_BPKB = $rcs_1['RELEASE_DATE_BPKB']; 
        $MATURITY_DT = $rcs_1['MATURITY_DT']; 
        $MATURITY_DURATION = $rcs_1['MATURITY_DURATION']; 
        $GO_LIVE_DT = $rcs_1['GO_LIVE_DT']; 
        $GO_LIVE_DURATION = $rcs_1['GO_LIVE_DURATION']; 
        $AAM_RRD_DT = $rcs_1['AAM_RRD_DT']; 
        $EXPIRED_MONTHS = $rcs_1['EXPIRED_MONTHS']; 
        $OS_PRINCIPAL = $rcs_1['OS_PRINCIPAL']; 
        $OS_PRINCIPAL_AMT = $rcs_1['OS_PRINCIPAL_AMT']; 
        $OS_INTEREST_AMT = $rcs_1['OS_INTEREST_AMT']; 
        $AGING_PEMBIAYAAN = $rcs_1['AGING_PEMBIAYAAN']; 
        $JUMLAH_KONTRAK_PERCUST = $rcs_1['JUMLAH_KONTRAK_PERCUST']; 
        $ESTIMASI_TERIMA_BERSIH = $rcs_1['ESTIMASI_TERIMA_BERSIH']; 
        $STARTED_DT = $rcs_1['STARTED_DT']; 
        $POS_DEALER = $rcs_1['POS_DEALER']; 
        $SALES_DEALER_ID = $rcs_1['SALES_DEALER_ID']; 
        $SALES_DEALER = $rcs_1['SALES_DEALER']; 
        $DTM_CRT = $rcs_1['DTM_CRT']; 
        $USR_CRT = $rcs_1['USR_CRT']; 
        $DTM_UPD = $rcs_1['DTM_UPD']; 
        $USR_UPD = $rcs_1['USR_UPD']; 
        $COLL_AGRMNT_ID = $rcs_1['COLL_AGRMNT_ID']; 
        $AGRMNT_ASSET_ID = $rcs_1['AGRMNT_ASSET_ID']; 
        $ASSET_MASTER_ID = $rcs_1['ASSET_MASTER_ID']; 
        $DEFAULT_STAT = $rcs_1['DEFAULT_STAT']; 
        $CUST_ID = $rcs_1['CUST_ID']; 
        $HOME_STAT = $rcs_1['HOME_STAT']; 
        $MOTHER_NAME = $rcs_1['MOTHER_NAME']; 
        $IS_EVER_REPO = $rcs_1['IS_EVER_REPO']; 
        $IS_REPO = $rcs_1['IS_REPO']; 
        $IS_WRITE_OFF = $rcs_1['IS_WRITE_OFF']; 
        $IS_RESTRUKTUR = $rcs_1['IS_RESTRUKTUR']; 
        $IS_INSURANCE = $rcs_1['IS_INSURANCE']; 
        $IS_NEGATIVE_CUST = $rcs_1['IS_NEGATIVE_CUST']; 
        $IS_ACCOUNT_BAM = $rcs_1['IS_ACCOUNT_BAM']; 
        $CUST_EXPOSURE = $rcs_1['CUST_EXPOSURE']; 
        $AGE = $rcs_1['AGE']; 
        $ASSET_AGE = $rcs_1['ASSET_AGE']; 
        $SAME_ASSET_GO_LIVE = $rcs_1['SAME_ASSET_GO_LIVE']; 
        $LTV = $rcs_1['LTV']; 
        $DSR = $rcs_1['DSR']; 
        $MARITAL_STAT = $rcs_1['MARITAL_STAT']; 
        $EDUCATION = $rcs_1['EDUCATION']; 
        $EMPLOYMENT_ESTABLISHMENT_DT = $rcs_1['EMPLOYMENT_ESTABLISHMENT_DT']; 
        $LENGTH_OF_WORK = $rcs_1['LENGTH_OF_WORK']; 
        $HOUSE_STAY_LENGTH = $rcs_1['HOUSE_STAY_LENGTH']; 
        $LAST_OVERDUE = $rcs_1['LAST_OVERDUE']; 
        $MAX_OVERDUE = $rcs_1['MAX_OVERDUE']; 
        $MAX_OVERDUE_LAST_X_MONTHS = $rcs_1['MAX_OVERDUE_LAST_X_MONTHS']; 
        $IS_USED = $rcs_1['IS_USED'];
        $SPOUSE_BIRTH_PLACE = $rcs_1['SPOUSE_BIRTH_PLACE'];

        $IS_SELECTED = $rcs_1['IS_SELECTED'];
        $PIPELINE_DUMMY_ID = $rcs_1['PIPELINE_DUMMY_ID'];
        $PIPELINE_DUMMY_IS_EARLY_WSC = $rcs_1['PIPELINE_DUMMY_IS_EARLY_WSC'];
        $FINAL_DT = $rcs_1['FINAL_DT'];

        $SPOUSE_PHONE = $rcs_1['SPOUSE_PHONE'];
        $SPOUSE_MOBILE_PHONE_NO = $rcs_1['SPOUSE_MOBILE_PHONE_NO'];
        $GUARANTOR_ID_NO = $rcs_1['GUARANTOR_ID_NO'];
        $GUARANTOR_NAME = $rcs_1['GUARANTOR_NAME'];
        $GUARANTOR_MOBILE_PHONE_NO = $rcs_1['GUARANTOR_MOBILE_PHONE_NO'];
        $GUARANTOR_BIRTH_PLACE = $rcs_1['GUARANTOR_BIRTH_PLACE'];
        $GUARANTOR_BIRTH_DT = $rcs_1['GUARANTOR_BIRTH_DT'];
        $GUARANTOR_ADDR = $rcs_1['GUARANTOR_ADDR'];
        $GUARANTOR_RT = $rcs_1['GUARANTOR_RT'];
        $GUARANTOR_RW = $rcs_1['GUARANTOR_RW'];
        $GUARANTOR_KELURAHAN = $rcs_1['GUARANTOR_KELURAHAN'];
        $GUARANTOR_KECAMATAN = $rcs_1['GUARANTOR_KECAMATAN'];
        $GUARANTOR_CITY = $rcs_1['GUARANTOR_CITY'];
        $GUARANTOR_PROVINSI = $rcs_1['GUARANTOR_PROVINSI'];
        $GUARANTOR_ZIPCODE = $rcs_1['GUARANTOR_ZIPCODE'];
        $GUARANTOR_SUBZIPCODE = $rcs_1['GUARANTOR_SUBZIPCODE'];
        $GUARANTOR_RELATIONSHIP = $rcs_1['GUARANTOR_RELATIONSHIP'];
        $SPOUSE_CUST_ID = $rcs_1['SPOUSE_CUST_ID'];
        $GUARANTOR_CUST_ID = $rcs_1['GUARANTOR_CUST_ID'];
        $IS_PRE_APPROVAL = $rcs_1['IS_PRE_APPROVAL'];

        $stmt = $dbopen->prepare("INSERT INTO cc_ts_penawaran_job SET
                        campaign_id = '0', 
                        AGRMNT_ID = '$AGRMNT_ID', 
                        AGRMNT_NO = '$AGRMNT_NO', 
                        AGRMNT_DT = '$AGRMNT_DT', 
                        PIPELINE_ID = '$PIPELINE_ID', 
                        JOB_ID = '$JOB_ID', 
                        IS_ACTIVE = '$IS_ACTIVE', 
                        DISTRIBUTED_DT = '$DISTRIBUTED_DT', 
                        DISTRIBUTED_USR = '$DISTRIBUTED_USR', 
                        IS_COMPLETE = '$IS_COMPLETE', 
                        COMPLETED_DT = '$COMPLETED_DT', 
                        CAE_FINAL_SCORE = '$CAE_FINAL_SCORE', 
                        CAE_FINAL_RESULT = '$CAE_FINAL_RESULT', 
                        CAE_RESULT = '$CAE_RESULT', 
                        CAE_DT = '$CAE_DT', 
                        DUKCAPIL = '$DUKCAPIL', 
                        DUKCAPIL_RESULT = '$DUKCAPIL_RESULT', 
                        DUKCAPIL_API_DT = '$DUKCAPIL_API_DT', 
                        SCHEME_ID = '$SCHEME_ID', 
                        SLIK_CBASID = '$SLIK_CBASID', 
                        SLIK_RESULT = '$SLIK_RESULT', 
                        SLIK_CATEGORY = '$SLIK_CATEGORY', 
                        SLIK_API_DT = '$SLIK_API_DT', 
                        SOURCE_DATA = '$SOURCE_DATA', 
                        KILAT_PINTAR = '$KILAT_PINTAR', 
                        BUSINESS_DATE = '$BUSINESS_DATE', 
                        OFFICE_REGION_CODE = '$OFFICE_REGION_CODE', 
                        OFFICE_REGION_NAME = '$OFFICE_REGION_NAME', 
                        OFFICE_CODE = '$OFFICE_CODE', 
                        OFFICE_NAME = '$OFFICE_NAME', 
                        CAB_COLL = '$CAB_COLL', 
                        CAB_COLL_NAME = '$CAB_COLL_NAME', 
                        KAPOS_NAME = '$KAPOS_NAME', 
                        PROD_OFFERING_CODE = '$PROD_OFFERING_CODE', 
                        LOB_CODE = '$LOB_CODE', 
                        CUST_TYPE = '$CUST_TYPE', 
                        CUST_NO = '$CUST_NO', 
                        CUST_NAME = '$CUST_NAME', 
                        ID_NO = '$ID_NO', 
                        GENDER = '$GENDER', 
                        RELIGION = '$RELIGION', 
                        BIRTH_PLACE = '$BIRTH_PLACE', 
                        BIRTH_DT = '$BIRTH_DT', 
                        SPOUSE_ID_NO = '$SPOUSE_ID_NO', 
                        SPOUSE_NAME = '$SPOUSE_NAME', 
                        SPOUSE_BIRTH_DT = '$SPOUSE_BIRTH_DT', 
                        ADDR_LEG = '$ADDR_LEG', 
                        RT_LEG = '$RT_LEG', 
                        RW_LEG = '$RW_LEG', 
                        PROVINSI_LEG = '$PROVINSI_LEG', 
                        CITY_LEG = '$CITY_LEG', 
                        KABUPATEN_LEG = '$KABUPATEN_LEG', 
                        KECAMATAN_LEG = '$KECAMATAN_LEG', 
                        KELURAHAN_LEG = '$KELURAHAN_LEG', 
                        ZIPCODE_LEG = '$ZIPCODE_LEG', 
                        SUB_ZIPCODE_LEG = '$SUB_ZIPCODE_LEG', 
                        ADDR_RES = '$ADDR_RES', 
                        RT_RES = '$RT_RES', 
                        RW_RES = '$RW_RES', 
                        PROVINSI_RES = '$PROVINSI_RES', 
                        CITY_RES = '$CITY_RES', 
                        KABUPATEN_RES = '$KABUPATEN_RES', 
                        KECAMATAN_RES = '$KECAMATAN_RES', 
                        KELURAHAN_RES = '$KELURAHAN_RES', 
                        ZIPCODE_RES = '$ZIPCODE_RES', 
                        SUB_ZIPCODE_RES = '$SUB_ZIPCODE_RES', 
                        MOBILE1 = '$MOBILE1', 
                        MOBILE2 = '$MOBILE2', 
                        PHONE1 = '$PHONE1', 
                        PHONE2 = '$PHONE2', 
                        OFFICE_PHONE1 = '$OFFICE_PHONE1', 
                        OFFICE_PHONE2 = '$OFFICE_PHONE2', 
                        PROFESSION_CODE = '$PROFESSION_CODE', 
                        PROFESSION_NAME = '$PROFESSION_NAME', 
                        PROFESSION_CATEGORY_CODE = '$PROFESSION_CATEGORY_CODE', 
                        PROFESSION_CATEGORY_NAME = '$PROFESSION_CATEGORY_NAME', 
                        JOB_POSITION = '$JOB_POSITION', 
                        JOB_STATUS = '$JOB_STATUS', 
                        INDUSTRY_TYPE_NAME = '$INDUSTRY_TYPE_NAME', 
                        OTHER_BIZ_NAME = '$OTHER_BIZ_NAME', 
                        MONTHLY_INCOME = '$MONTHLY_INCOME', 
                        MONTHLY_EXPENSE = '$MONTHLY_EXPENSE', 
                        MONTHLY_INSTALLMENT = '$MONTHLY_INSTALLMENT', 
                        DOWNPAYMENT = '$DOWNPAYMENT', 
                        PERCENT_DP = '$PERCENT_DP', 
                        PLAFOND = '$PLAFOND', 
                        CUST_RATING = '$CUST_RATING', 
                        SUPPL_NAME = '$SUPPL_NAME', 
                        SUPPL_CODE = '$SUPPL_CODE', 
                        MACHINE_NO = '$MACHINE_NO', 
                        CHASSIS_NO = '$CHASSIS_NO', 
                        PRODUCT_CATEGORY = '$PRODUCT_CATEGORY', 
                        ASSET_CATEGORY_CODE = '$ASSET_CATEGORY_CODE', 
                        ASSET_TYPE = '$ASSET_TYPE', 
                        ITEM_BRAND = '$ITEM_BRAND', 
                        ITEM_TYPE = '$ITEM_TYPE', 
                        ITEM_DESCRIPTION = '$ITEM_DESCRIPTION', 
                        ASSET_MODEL = '$ASSET_MODEL', 
                        OTR_PRICE = '$OTR_PRICE', 
                        ITEM_YEAR = '$ITEM_YEAR', 
                        OWNER_RELATIONSHIP = '$OWNER_RELATIONSHIP', 
                        BPKB_OWNERSHIP = '$BPKB_OWNERSHIP', 
                        AGRMNT_RATING = '$AGRMNT_RATING', 
                        CONTRACT_STAT = '$CONTRACT_STAT', 
                        INST_PAYED = '$INST_PAYED', 
                        NEXT_INST_NUM = '$NEXT_INST_NUM', 
                        NEXT_INST_DT = '$NEXT_INST_DT', 
                        OS_TENOR = '$OS_TENOR', 
                        TENOR = '$TENOR', 
                        RELEASE_DATE_BPKB = '$RELEASE_DATE_BPKB', 
                        MATURITY_DT = '$MATURITY_DT', 
                        MATURITY_DURATION = '$MATURITY_DURATION', 
                        GO_LIVE_DT = '$GO_LIVE_DT', 
                        GO_LIVE_DURATION = '$GO_LIVE_DURATION', 
                        AAM_RRD_DT = '$AAM_RRD_DT', 
                        EXPIRED_MONTHS = '$EXPIRED_MONTHS', 
                        OS_PRINCIPAL = '$OS_PRINCIPAL', 
                        OS_PRINCIPAL_AMT = '$OS_PRINCIPAL_AMT', 
                        OS_INTEREST_AMT = '$OS_INTEREST_AMT', 
                        AGING_PEMBIAYAAN = '$AGING_PEMBIAYAAN', 
                        JUMLAH_KONTRAK_PERCUST = '$JUMLAH_KONTRAK_PERCUST', 
                        ESTIMASI_TERIMA_BERSIH = '$ESTIMASI_TERIMA_BERSIH', 
                        STARTED_DT = '$STARTED_DT', 
                        POS_DEALER = '$POS_DEALER', 
                        SALES_DEALER_ID = '$SALES_DEALER_ID', 
                        SALES_DEALER = '$SALES_DEALER', 
                        DTM_CRT = '$DTM_CRT', 
                        USR_CRT = '$USR_CRT', 
                        DTM_UPD = '$DTM_UPD', 
                        USR_UPD = '$USR_UPD', 
                        COLL_AGRMNT_ID = '$COLL_AGRMNT_ID', 
                        AGRMNT_ASSET_ID = '$AGRMNT_ASSET_ID', 
                        ASSET_MASTER_ID = '$ASSET_MASTER_ID', 
                        DEFAULT_STAT = '$DEFAULT_STAT', 
                        CUST_ID = '$CUST_ID', 
                        HOME_STAT = '$HOME_STAT', 
                        MOTHER_NAME = '$MOTHER_NAME', 
                        IS_EVER_REPO = '$IS_EVER_REPO', 
                        IS_REPO = '$IS_REPO', 
                        IS_WRITE_OFF = '$IS_WRITE_OFF', 
                        IS_RESTRUKTUR = '$IS_RESTRUKTUR', 
                        IS_INSURANCE = '$IS_INSURANCE', 
                        IS_NEGATIVE_CUST = '$IS_NEGATIVE_CUST', 
                        IS_ACCOUNT_BAM = '$IS_ACCOUNT_BAM', 
                        CUST_EXPOSURE = '$CUST_EXPOSURE', 
                        AGE = '$AGE', 
                        ASSET_AGE = '$ASSET_AGE', 
                        SAME_ASSET_GO_LIVE = '$SAME_ASSET_GO_LIVE', 
                        LTV = '$LTV', 
                        DSR = '$DSR', 
                        MARITAL_STAT = '$MARITAL_STAT', 
                        EDUCATION = '$EDUCATION', 
                        EMPLOYMENT_ESTABLISHMENT_DT = '$EMPLOYMENT_ESTABLISHMENT_DT', 
                        LENGTH_OF_WORK = '$LENGTH_OF_WORK', 
                        HOUSE_STAY_LENGTH = '$HOUSE_STAY_LENGTH', 
                        LAST_OVERDUE = '$LAST_OVERDUE', 
                        MAX_OVERDUE = '$MAX_OVERDUE', 
                        MAX_OVERDUE_LAST_X_MONTHS = '$MAX_OVERDUE_LAST_X_MONTHS', 
                        IS_USED = '$IS_USED',
                        SPOUSE_BIRTH_PLACE = '$SPOUSE_BIRTH_PLACE',
                        IS_SELECTED = '$IS_SELECTED',
                        PIPELINE_DUMMY_ID = '$PIPELINE_DUMMY_ID',
                        PIPELINE_DUMMY_IS_EARLY_WSC = '$PIPELINE_DUMMY_IS_EARLY_WSC',
                        FINAL_DT = '$FINAL_DT',
                        SPOUSE_PHONE = '$SPOUSE_PHONE',
                        SPOUSE_MOBILE_PHONE_NO = '$SPOUSE_MOBILE_PHONE_NO',
                        GUARANTOR_ID_NO = '$GUARANTOR_ID_NO',
                        GUARANTOR_NAME = '$GUARANTOR_NAME',
                        GUARANTOR_MOBILE_PHONE_NO = '$GUARANTOR_MOBILE_PHONE_NO',
                        GUARANTOR_BIRTH_PLACE = '$GUARANTOR_BIRTH_PLACE',
                        GUARANTOR_BIRTH_DT = '$GUARANTOR_BIRTH_DT',
                        GUARANTOR_ADDR = '$GUARANTOR_ADDR',
                        GUARANTOR_RT = '$GUARANTOR_RT',
                        GUARANTOR_RW = '$GUARANTOR_RW',
                        GUARANTOR_KELURAHAN = '$GUARANTOR_KELURAHAN',
                        GUARANTOR_KECAMATAN = '$GUARANTOR_KECAMATAN',
                        GUARANTOR_CITY = '$GUARANTOR_CITY',
                        GUARANTOR_PROVINSI = '$GUARANTOR_PROVINSI',
                        GUARANTOR_ZIPCODE = '$GUARANTOR_ZIPCODE',
                        GUARANTOR_SUBZIPCODE = '$GUARANTOR_SUBZIPCODE',
                        GUARANTOR_RELATIONSHIP = '$GUARANTOR_RELATIONSHIP',
                        SPOUSE_CUST_ID = '$SPOUSE_CUST_ID',
                        GUARANTOR_CUST_ID = '$GUARANTOR_CUST_ID',
                        is_eligible_crm = '1',
                        is_process = '1', 
                        IS_PRE_APPROVAL = '$IS_PRE_APPROVAL', 
                        SYNC_TIME=now()
                    ON DUPLICATE KEY UPDATE 
                        campaign_id = '0', 
                        AGRMNT_ID = '$AGRMNT_ID', 
                        AGRMNT_NO = '$AGRMNT_NO', 
                        AGRMNT_DT = '$AGRMNT_DT', 
                        PIPELINE_ID = '$PIPELINE_ID', 
                        JOB_ID = '$JOB_ID', 
                        IS_ACTIVE = '$IS_ACTIVE', 
                        DISTRIBUTED_DT = '$DISTRIBUTED_DT', 
                        DISTRIBUTED_USR = '$DISTRIBUTED_USR', 
                        IS_COMPLETE = '$IS_COMPLETE', 
                        COMPLETED_DT = '$COMPLETED_DT', 
                        CAE_FINAL_SCORE = '$CAE_FINAL_SCORE', 
                        CAE_FINAL_RESULT = '$CAE_FINAL_RESULT', 
                        CAE_RESULT = '$CAE_RESULT', 
                        CAE_DT = '$CAE_DT', 
                        DUKCAPIL = '$DUKCAPIL', 
                        DUKCAPIL_RESULT = '$DUKCAPIL_RESULT', 
                        DUKCAPIL_API_DT = '$DUKCAPIL_API_DT', 
                        SCHEME_ID = '$SCHEME_ID', 
                        SLIK_CBASID = '$SLIK_CBASID', 
                        SLIK_RESULT = '$SLIK_RESULT', 
                        SLIK_CATEGORY = '$SLIK_CATEGORY', 
                        SLIK_API_DT = '$SLIK_API_DT', 
                        SOURCE_DATA = '$SOURCE_DATA', 
                        KILAT_PINTAR = '$KILAT_PINTAR', 
                        BUSINESS_DATE = '$BUSINESS_DATE', 
                        OFFICE_REGION_CODE = '$OFFICE_REGION_CODE', 
                        OFFICE_REGION_NAME = '$OFFICE_REGION_NAME', 
                        OFFICE_CODE = '$OFFICE_CODE', 
                        OFFICE_NAME = '$OFFICE_NAME', 
                        CAB_COLL = '$CAB_COLL', 
                        CAB_COLL_NAME = '$CAB_COLL_NAME', 
                        KAPOS_NAME = '$KAPOS_NAME', 
                        PROD_OFFERING_CODE = '$PROD_OFFERING_CODE', 
                        LOB_CODE = '$LOB_CODE', 
                        CUST_TYPE = '$CUST_TYPE', 
                        CUST_NO = '$CUST_NO', 
                        CUST_NAME = '$CUST_NAME', 
                        ID_NO = '$ID_NO', 
                        GENDER = '$GENDER', 
                        RELIGION = '$RELIGION', 
                        BIRTH_PLACE = '$BIRTH_PLACE', 
                        BIRTH_DT = '$BIRTH_DT', 
                        SPOUSE_ID_NO = '$SPOUSE_ID_NO', 
                        SPOUSE_NAME = '$SPOUSE_NAME', 
                        SPOUSE_BIRTH_DT = '$SPOUSE_BIRTH_DT', 
                        ADDR_LEG = '$ADDR_LEG', 
                        RT_LEG = '$RT_LEG', 
                        RW_LEG = '$RW_LEG', 
                        PROVINSI_LEG = '$PROVINSI_LEG', 
                        CITY_LEG = '$CITY_LEG', 
                        KABUPATEN_LEG = '$KABUPATEN_LEG', 
                        KECAMATAN_LEG = '$KECAMATAN_LEG', 
                        KELURAHAN_LEG = '$KELURAHAN_LEG', 
                        ZIPCODE_LEG = '$ZIPCODE_LEG', 
                        SUB_ZIPCODE_LEG = '$SUB_ZIPCODE_LEG', 
                        ADDR_RES = '$ADDR_RES', 
                        RT_RES = '$RT_RES', 
                        RW_RES = '$RW_RES', 
                        PROVINSI_RES = '$PROVINSI_RES', 
                        CITY_RES = '$CITY_RES', 
                        KABUPATEN_RES = '$KABUPATEN_RES', 
                        KECAMATAN_RES = '$KECAMATAN_RES', 
                        KELURAHAN_RES = '$KELURAHAN_RES', 
                        ZIPCODE_RES = '$ZIPCODE_RES', 
                        SUB_ZIPCODE_RES = '$SUB_ZIPCODE_RES', 
                        MOBILE1 = '$MOBILE1', 
                        MOBILE2 = '$MOBILE2', 
                        PHONE1 = '$PHONE1', 
                        PHONE2 = '$PHONE2', 
                        OFFICE_PHONE1 = '$OFFICE_PHONE1', 
                        OFFICE_PHONE2 = '$OFFICE_PHONE2', 
                        PROFESSION_CODE = '$PROFESSION_CODE', 
                        PROFESSION_NAME = '$PROFESSION_NAME', 
                        PROFESSION_CATEGORY_CODE = '$PROFESSION_CATEGORY_CODE', 
                        PROFESSION_CATEGORY_NAME = '$PROFESSION_CATEGORY_NAME', 
                        JOB_POSITION = '$JOB_POSITION', 
                        JOB_STATUS = '$JOB_STATUS', 
                        INDUSTRY_TYPE_NAME = '$INDUSTRY_TYPE_NAME', 
                        OTHER_BIZ_NAME = '$OTHER_BIZ_NAME', 
                        MONTHLY_INCOME = '$MONTHLY_INCOME', 
                        MONTHLY_EXPENSE = '$MONTHLY_EXPENSE', 
                        MONTHLY_INSTALLMENT = '$MONTHLY_INSTALLMENT', 
                        DOWNPAYMENT = '$DOWNPAYMENT', 
                        PERCENT_DP = '$PERCENT_DP', 
                        PLAFOND = '$PLAFOND', 
                        CUST_RATING = '$CUST_RATING', 
                        SUPPL_NAME = '$SUPPL_NAME', 
                        SUPPL_CODE = '$SUPPL_CODE', 
                        MACHINE_NO = '$MACHINE_NO', 
                        CHASSIS_NO = '$CHASSIS_NO', 
                        PRODUCT_CATEGORY = '$PRODUCT_CATEGORY', 
                        ASSET_CATEGORY_CODE = '$ASSET_CATEGORY_CODE', 
                        ASSET_TYPE = '$ASSET_TYPE', 
                        ITEM_BRAND = '$ITEM_BRAND', 
                        ITEM_TYPE = '$ITEM_TYPE', 
                        ITEM_DESCRIPTION = '$ITEM_DESCRIPTION', 
                        ASSET_MODEL = '$ASSET_MODEL', 
                        OTR_PRICE = '$OTR_PRICE', 
                        ITEM_YEAR = '$ITEM_YEAR', 
                        OWNER_RELATIONSHIP = '$OWNER_RELATIONSHIP', 
                        BPKB_OWNERSHIP = '$BPKB_OWNERSHIP', 
                        AGRMNT_RATING = '$AGRMNT_RATING', 
                        CONTRACT_STAT = '$CONTRACT_STAT', 
                        INST_PAYED = '$INST_PAYED', 
                        NEXT_INST_NUM = '$NEXT_INST_NUM', 
                        NEXT_INST_DT = '$NEXT_INST_DT', 
                        OS_TENOR = '$OS_TENOR', 
                        TENOR = '$TENOR', 
                        RELEASE_DATE_BPKB = '$RELEASE_DATE_BPKB', 
                        MATURITY_DT = '$MATURITY_DT', 
                        MATURITY_DURATION = '$MATURITY_DURATION', 
                        GO_LIVE_DT = '$GO_LIVE_DT', 
                        GO_LIVE_DURATION = '$GO_LIVE_DURATION', 
                        AAM_RRD_DT = '$AAM_RRD_DT', 
                        EXPIRED_MONTHS = '$EXPIRED_MONTHS', 
                        OS_PRINCIPAL = '$OS_PRINCIPAL', 
                        OS_PRINCIPAL_AMT = '$OS_PRINCIPAL_AMT', 
                        OS_INTEREST_AMT = '$OS_INTEREST_AMT', 
                        AGING_PEMBIAYAAN = '$AGING_PEMBIAYAAN', 
                        JUMLAH_KONTRAK_PERCUST = '$JUMLAH_KONTRAK_PERCUST', 
                        ESTIMASI_TERIMA_BERSIH = '$ESTIMASI_TERIMA_BERSIH', 
                        STARTED_DT = '$STARTED_DT', 
                        POS_DEALER = '$POS_DEALER', 
                        SALES_DEALER_ID = '$SALES_DEALER_ID', 
                        SALES_DEALER = '$SALES_DEALER', 
                        DTM_CRT = '$DTM_CRT', 
                        USR_CRT = '$USR_CRT', 
                        DTM_UPD = '$DTM_UPD', 
                        USR_UPD = '$USR_UPD', 
                        COLL_AGRMNT_ID = '$COLL_AGRMNT_ID', 
                        AGRMNT_ASSET_ID = '$AGRMNT_ASSET_ID', 
                        ASSET_MASTER_ID = '$ASSET_MASTER_ID', 
                        DEFAULT_STAT = '$DEFAULT_STAT', 
                        CUST_ID = '$CUST_ID', 
                        HOME_STAT = '$HOME_STAT', 
                        MOTHER_NAME = '$MOTHER_NAME', 
                        IS_EVER_REPO = '$IS_EVER_REPO', 
                        IS_REPO = '$IS_REPO', 
                        IS_WRITE_OFF = '$IS_WRITE_OFF', 
                        IS_RESTRUKTUR = '$IS_RESTRUKTUR', 
                        IS_INSURANCE = '$IS_INSURANCE', 
                        IS_NEGATIVE_CUST = '$IS_NEGATIVE_CUST', 
                        IS_ACCOUNT_BAM = '$IS_ACCOUNT_BAM', 
                        CUST_EXPOSURE = '$CUST_EXPOSURE', 
                        AGE = '$AGE', 
                        ASSET_AGE = '$ASSET_AGE', 
                        SAME_ASSET_GO_LIVE = '$SAME_ASSET_GO_LIVE', 
                        LTV = '$LTV', 
                        DSR = '$DSR', 
                        MARITAL_STAT = '$MARITAL_STAT', 
                        EDUCATION = '$EDUCATION', 
                        EMPLOYMENT_ESTABLISHMENT_DT = '$EMPLOYMENT_ESTABLISHMENT_DT', 
                        LENGTH_OF_WORK = '$LENGTH_OF_WORK', 
                        HOUSE_STAY_LENGTH = '$HOUSE_STAY_LENGTH', 
                        LAST_OVERDUE = '$LAST_OVERDUE', 
                        MAX_OVERDUE = '$MAX_OVERDUE', 
                        MAX_OVERDUE_LAST_X_MONTHS = '$MAX_OVERDUE_LAST_X_MONTHS', 
                        IS_USED = '$IS_USED', 
                        SPOUSE_BIRTH_PLACE = '$SPOUSE_BIRTH_PLACE',
                        IS_SELECTED = '$IS_SELECTED',
                        PIPELINE_DUMMY_ID = '$PIPELINE_DUMMY_ID',
                        PIPELINE_DUMMY_IS_EARLY_WSC = '$PIPELINE_DUMMY_IS_EARLY_WSC',
                        FINAL_DT = '$FINAL_DT',
                        SPOUSE_PHONE = '$SPOUSE_PHONE',
                        SPOUSE_MOBILE_PHONE_NO = '$SPOUSE_MOBILE_PHONE_NO',
                        GUARANTOR_ID_NO = '$GUARANTOR_ID_NO',
                        GUARANTOR_NAME = '$GUARANTOR_NAME',
                        GUARANTOR_MOBILE_PHONE_NO = '$GUARANTOR_MOBILE_PHONE_NO',
                        GUARANTOR_BIRTH_PLACE = '$GUARANTOR_BIRTH_PLACE',
                        GUARANTOR_BIRTH_DT = '$GUARANTOR_BIRTH_DT',
                        GUARANTOR_ADDR = '$GUARANTOR_ADDR',
                        GUARANTOR_RT = '$GUARANTOR_RT',
                        GUARANTOR_RW = '$GUARANTOR_RW',
                        GUARANTOR_KELURAHAN = '$GUARANTOR_KELURAHAN',
                        GUARANTOR_KECAMATAN = '$GUARANTOR_KECAMATAN',
                        GUARANTOR_CITY = '$GUARANTOR_CITY',
                        GUARANTOR_PROVINSI = '$GUARANTOR_PROVINSI',
                        GUARANTOR_ZIPCODE = '$GUARANTOR_ZIPCODE',
                        GUARANTOR_SUBZIPCODE = '$GUARANTOR_SUBZIPCODE',
                        GUARANTOR_RELATIONSHIP = '$GUARANTOR_RELATIONSHIP',
                        SPOUSE_CUST_ID = '$SPOUSE_CUST_ID',
                        GUARANTOR_CUST_ID = '$GUARANTOR_CUST_ID',
                        is_eligible_crm = '1',
                        is_process = '1', 
                        IS_PRE_APPROVAL = '$IS_PRE_APPROVAL', 
                        SYNC_TIME=now()");
        if($resin =  $stmt->execute()){
            $idcus = mysqli_insert_id($dbopen);

            $suc1++;
        }else{
            $err1++;
            if ($err_agrmn1=="") {
                $err_agrmn1="$AGRMNT_NO";
                $err_desc = mysqli_error($dbopen).";";
            }else{
                $err_agrmn1 .=", $AGRMNT_NO";
                $err_desc .= "</br>".mysqli_error($dbopen).";";
            }
            
        }
        $stmt->close();

    }
    
} catch (\PDOException $e) {
    // Penanganan error
    error_log("Query database gagal: " . $e->getMessage());
}


    $err_desc = $err_desc;
    $sqllog = "INSERT INTO cc_log_sync_data SET 
                  sync_desc       ='V_MKT_POLO_ELIGIBLE',
                  sync_success    ='$suc1',
                  sync_error      ='$err1',
                  sync_error_agrmnt_no ='$err_agrmn1',
                  sync_error_desc ='$err_desc',
                  exe_time        = '$dateexe',
                  sync_time       =now()";
    $stmt = $dbopen->prepare($sqllog);
    $reslog = $stmt->execute();
    $stmt->close();

$suc2=0;
$err2=0;
$puteran=0;
$sqlcg = "SELECT 
          a.*
          FROM 
          cc_ts_penawaran_campaign a 
          WHERE a.campaign_priority > 0 AND status=1 
          AND POSITION('WISE' IN a.data_source) > 0
          ORDER BY a.campaign_priority ASC ";
$stmt = $dbopen->prepare($sqlcg);
$rescg = $stmt->execute();
$stmt->close();
while($reccg = mysqli_fetch_array($rescg)){
    $idcc                               = $reccg['id'];
    $data_source                        = $reccg['data_source'];
    $type_asset                       = $reccg['type_asset'];
    $pipeline                         = $reccg['pipeline'];
    $level                            = $reccg['level'];
    $branch                           = $reccg['branch'];
    $branch_code                           = $reccg['branch_code'];
    $regional                         = $reccg['regional'];
    $kendaraan                        = $reccg['kendaraan'];
    $product                          = $reccg['product'];
    $priority_sisa_tenor                             = $reccg['priority_sisa_tenor'];
    $priority_sisa_tenor_from                             = $reccg['priority_sisa_tenor_from'];
    $priority_sisa_tenor_to                             = $reccg['priority_sisa_tenor_to'];
    $status_konsumen                             = $reccg['status_konsumen'];
    $status_kontrak                             = $reccg['status_kontrak'];
    $kepemilikan_rumah                             = $reccg['kepemilikan_rumah'];
    $kepemilikan_bpkb                             = $reccg['kepemilikan_bpkb'];
    $distribution_spv                             = $reccg['distribution_spv'];
    $aging_pembiayaan                             = $reccg['aging_pembiayaan'];
    $aging_pembiayaan_from                             = $reccg['aging_pembiayaan_from'];
    $aging_pembiayaan_to                             = $reccg['aging_pembiayaan_to'];
    $cust_age                             = $reccg['cust_age'];
    $cust_age_from                             = $reccg['cust_age_from'];
    $cust_age_to                             = $reccg['cust_age_to'];
    $cust_birthday_month                             = $reccg['cust_birthday_month'];
    $cust_birthday_month_from                             = $reccg['cust_birthday_month_from'];
    $cust_birthday_month_to                             = $reccg['cust_birthday_month_to'];
    $cust_rating                             = $reccg['cust_rating'];
    $gender                             = $reccg['gender'];
    $industry_type                             = $reccg['industry_type'];
    $item_year                             = $reccg['item_year'];
    $item_year_from                             = $reccg['item_year_from'];
    $item_year_to                             = $reccg['item_year_to'];
    $jenis_kendaraan                             = $reccg['jenis_kendaraan'];
    $max_past_due                             = $reccg['max_past_due'];
    $max_past_due_from                             = $reccg['max_past_due_from'];
    $max_past_due_to                             = $reccg['max_past_due_to'];
    $cust_monthly_income                             = $reccg['cust_monthly_income'];
    $cust_monthly_income_from                             = $reccg['cust_monthly_income_from'];
    $cust_monthly_income_to                             = $reccg['cust_monthly_income_to'];
    $otr                             = $reccg['otr'];
    $otr_from                             = $reccg['otr_from'];
    $otr_to                             = $reccg['otr_to'];
    $profession                             = $reccg['profession'];
    $religion                             = $reccg['religion'];
    $flag_potensi                             = $reccg['flag_potensi'];

    $puteran++;
    
    $sqllog = "INSERT INTO cc_log_service_get SET 
                  campaign_id       ='$idcc',
                  `desc`            ='puteran campaign',
                  insert_time       =now()";
    $stmt = $dbopen->prepare($sqllog);
    $reslog = $stmt->execute();
    $stmt->close();
    
    $sql_whr="";
    if ($data_source!="" && $data_source!="0") {
        $data_source = str_replace(",", "','", $data_source);
        $data_source = str_replace("(POTENSIAL DATA RO)", "", $data_source); 
        $sql_whr .=" AND SOURCE_DATA IN ('$data_source')";
    }
    if ($type_asset!="" && $type_asset!="0") {
        $type_asset = str_replace(",", "','", $type_asset);
        $sql_whr .=" AND ASSET_TYPE IN ('$type_asset')";
    }
    if ($pipeline!="" && $pipeline!="0") {
        $pipeline = str_replace(",", "','", $pipeline);
        $sql_whr .=" AND PIPELINE_ID IN ('$pipeline')";
    }
    if ($level!="" && $level!="0") {
        $level = str_replace(",", "','", $level);
        // $sql_whr .=" AND *** IN ('$level')";
    }
    if ($branch_code!="" && $branch_code!="0") {
        $branch_code = str_replace(",", "','", $branch_code);
        $sql_whr .=" AND OFFICE_CODE IN ('$branch_code')";
    }
    if ($regional!="" && $regional!="0") {
        $regional = str_replace(",", "','", $regional);
        $sql_whr .=" AND OFFICE_REGION_CODE IN ('$regional')";
    }
    if ($kendaraan!="" && $kendaraan!="0") {
        $kendaraan = str_replace(",", "','", $kendaraan);
        // $sql_whr .=" AND *** IN ('$kendaraan')";
    }
    if ($product!="" && $product!="0") {
        $product = str_replace(",", "','", $product);
        $sql_whr .=" AND LOB_CODE IN ('$product')";
    }
    if ($priority_sisa_tenor_from!="") {
        $sql_whr .=" AND OS_TENOR >= CAST('".$priority_sisa_tenor_from."' as DECIMAL(65))";
    }
    if ($priority_sisa_tenor_to!="") {
        $sql_whr .=" AND OS_TENOR <= CAST('".$priority_sisa_tenor_to."' as DECIMAL(65))";
    }
    if ($status_kontrak!="" && $status_kontrak!="0") {
        $status_kontrak = str_replace(",", "','", $status_kontrak);
        $sql_whr .=" AND CONTRACT_STAT IN ('$status_kontrak')";
    }
    if ($kepemilikan_rumah!="" && $kepemilikan_rumah!="0") {
        $kepemilikan_rumah = str_replace(",", "','", $kepemilikan_rumah);
        $sqlch = "SELECT 
          a.*
          FROM 
          cc_master_house_ownership a 
          WHERE a.descr IN ('$kepemilikan_rumah')";
        $stmt = $dbopen->prepare($sqlch);
        $resch = $stmt->execute();
        $stmt->close();
        while($recch = mysqli_fetch_array($resch)){
            $master_code = $recch['master_code'];
            $descr = $recch['descr'];
            $kepemilikan_rumah = str_replace("$descr", "$master_code", $kepemilikan_rumah);
        }
        $sql_whr .=" AND HOME_STAT IN ('$kepemilikan_rumah')";
    }
    if ($kepemilikan_bpkb!="" && $kepemilikan_bpkb!="0") {
        $kepemilikan_bpkb = str_replace(",", "','", $kepemilikan_bpkb);
        $sql_whr .=" AND BPKB_OWNERSHIP IN ('$kepemilikan_bpkb')";
    }
    if ($distribution_spv!="" && $distribution_spv!="0") {
        $distribution_spv = str_replace(",", "','", $distribution_spv);
        // $sql_whr .=" AND *** IN ('$distribution_spv')";
    }
    if ($aging_pembiayaan_from!="") {
        $sql_whr .=" AND MATURITY_DURATION >= CAST('".$aging_pembiayaan_from."' as DECIMAL(65))";
    }
    if ($aging_pembiayaan_to!="") {
        $sql_whr .=" AND MATURITY_DURATION <= CAST('".$aging_pembiayaan_to."' as DECIMAL(65))";
    }
    if ($cust_age_from!="" && $cust_age_from!="0") {
        $sql_whr .=" AND AGE >= CAST('".$cust_age_from."' as DECIMAL(65))";
    }
    if ($cust_age_to!="" && $cust_age_to!="0") {
        $sql_whr .=" AND AGE <= CAST('".$cust_age_to."' as DECIMAL(65))";
    }
    if ($cust_birthday_month_from!="" && $cust_birthday_month_from!="0") {
        $sql_whr .=" AND MONTH(BIRTH_DT) >= '$cust_birthday_month_from'";
    }
    if ($cust_birthday_month_to!="" && $cust_birthday_month_to!="0") {
        $sql_whr .=" AND MONTH(BIRTH_DT) <= '$cust_birthday_month_to'";
    }
    
    if ($cust_rating!="" && $cust_rating!="0") {
        $cust_rating = str_replace(",", "','", $cust_rating);
        $cust_rating = str_replace("1", "EXCELLENT", $cust_rating);
        $cust_rating = str_replace("2", "GOOD", $cust_rating);
        $cust_rating = str_replace("3", "NORMAL", $cust_rating);
        $sql_whr .=" AND CUST_RATING IN ('$cust_rating')";
    }
    if ($gender!="" && $gender!="0") {
        $gender = str_replace(",", "','", $gender);
        $gender = str_replace("1", "Laki - laki','LAKI-LAKI','M','MALE", $gender);
        $gender = str_replace("2", "F','Female','PEREMPUAN", $gender);
        $gender = str_replace("''", "'", $gender);
        $sql_whr .=" AND GENDER IN ('$gender')";
    }
    if ($industry_type!="" && $industry_type!="0") {
        $industry_type = str_replace(",", "','", $industry_type);
        $sql_whr .=" AND INDUSTRY_TYPE_NAME IN ('$industry_type')";
    }
    if ($jenis_kendaraan!="" && $jenis_kendaraan!="0") {
        $jenis_kendaraan = str_replace(",", "','", $jenis_kendaraan);
    }
    if ($item_year_from!="" && $item_year_from!="0") {
        $sql_whr .=" AND ITEM_YEAR >= '$item_year_from'";
    }
    if ($item_year_to!="" && $item_year_to!="0") {
        $sql_whr .=" AND ITEM_YEAR <= '$item_year_to'";
    }
    if ($max_past_due_from!="" && $max_past_due_from!="0") {
        $sql_whr .=" AND MAX_OVERDUE >= CAST('".$max_past_due_from."' as DECIMAL(65))";
    }
    if ($max_past_due_to!="" && $max_past_due_to!="0") {
        $sql_whr .=" AND MAX_OVERDUE <= CAST('".$max_past_due_to."' as DECIMAL(65))";
    }
    if ($cust_monthly_income_from!="" && $cust_monthly_income_from!="0") {
        $cust_monthly_income_from = str_replace(".", "", $cust_monthly_income_from);
        $sql_whr .=" AND MONTHLY_INCOME >= '$cust_monthly_income_from'";
    }
    if ($cust_monthly_income_to!="" && $cust_monthly_income_to!="0") {
        $cust_monthly_income_to = str_replace(".", "", $cust_monthly_income_to);
        $sql_whr .=" AND MONTHLY_INCOME <= '$cust_monthly_income_to'";
    }
    if ($otr_from!="" && $otr_from!="0") {
        $otr_from = str_replace(".", "", $otr_from);
        $sql_whr .=" AND OTR_PRICE >= '$otr_from'";
    }
    if ($otr_to!="" && $otr_to!="0") {
        $otr_to = str_replace(".", "", $otr_to);
        $sql_whr .=" AND OTR_PRICE <= '$otr_to'";
    }
    if ($religion!="" && $religion!="0") {
        $religion = str_replace(",", "','", $religion);
        $sql_whr .=" AND RELIGION IN ('$religion')";
    }
    if ($profession!=""&&$profession!="0") {
        $profession = str_replace(",", "','", $profession);
        $sql_whr .=" AND PROFESSION_CODE IN ('$profession')";
    }

    //start customer detail
    $suc3=0;
    $err3=0;
    $sqlcektoday = "SELECT 
                a.*
              FROM 
                cc_ts_penawaran_job a 
              WHERE campaign_id='0' $sql_whr ";
              
    $stmt = $dbopen->prepare($sqlcektoday);
    $rescektoday = $stmt->execute();
    $stmt->close();
    if($reccektoday = mysqli_fetch_array($rescektoday)){
        $id_today_upd  = $reccektoday['id']; 

        $sqllog = "INSERT INTO cc_log_service_get SET 
                      campaign_id       ='$idcc',
                      `desc`            ='puteran consumer_detail',
                      insert_time       =now()";
        $stmt = $dbopen->prepare($sqllog);
        $reslog = $stmt->execute();
        $stmt->close();

        $sqlupdt = "";

        $sqltodayupdt = "UPDATE cc_ts_penawaran_job
                         SET $sqlupdt campaign_id = '$idcc'
                         WHERE campaign_id='0' $sql_whr ";
        $stmt =  $dbopen->prepare($sqltodayupdt)
        if($reslog = $stmt->execute()){ 
           $suc2++;
        }else{
           $err2++;
        }
        $stmt->close();

    }
    mysqli_free_result($rescektoday);

}


    $sqljob = "SELECT * FROM cc_ts_penawaran_job
              WHERE campaign_id='0' AND SOURCE_DATA = 'WISE'";
    $stmt = $dbopen->prepare($sqljob);
    $resjob = $stmt->execute();
    $stmt->close();
    while($recjob = mysqli_fetch_array($resjob)){
        @extract($recjob,EXTR_OVERWRITE);

        $sql_in2 = "INSERT INTO cc_ts_penawaran_job_temp SET
                        campaign_id = '0', 
                        AGRMNT_ID = '$AGRMNT_ID', 
                        AGRMNT_NO = '$AGRMNT_NO', 
                        AGRMNT_DT = '$AGRMNT_DT', 
                        PIPELINE_ID = '$PIPELINE_ID', 
                        JOB_ID = '$JOB_ID', 
                        IS_ACTIVE = '$IS_ACTIVE', 
                        DISTRIBUTED_DT = '$DISTRIBUTED_DT', 
                        DISTRIBUTED_USR = '$DISTRIBUTED_USR', 
                        IS_COMPLETE = '$IS_COMPLETE', 
                        COMPLETED_DT = '$COMPLETED_DT', 
                        CAE_FINAL_SCORE = '$CAE_FINAL_SCORE', 
                        CAE_FINAL_RESULT = '$CAE_FINAL_RESULT', 
                        CAE_RESULT = '$CAE_RESULT', 
                        CAE_DT = '$CAE_DT', 
                        DUKCAPIL = '$DUKCAPIL', 
                        DUKCAPIL_RESULT = '$DUKCAPIL_RESULT', 
                        DUKCAPIL_API_DT = '$DUKCAPIL_API_DT', 
                        SCHEME_ID = '$SCHEME_ID', 
                        SLIK_CBASID = '$SLIK_CBASID', 
                        SLIK_RESULT = '$SLIK_RESULT', 
                        SLIK_CATEGORY = '$SLIK_CATEGORY', 
                        SLIK_API_DT = '$SLIK_API_DT', 
                        SOURCE_DATA = '$SOURCE_DATA', 
                        KILAT_PINTAR = '$KILAT_PINTAR', 
                        BUSINESS_DATE = '$BUSINESS_DATE', 
                        OFFICE_REGION_CODE = '$OFFICE_REGION_CODE', 
                        OFFICE_REGION_NAME = '$OFFICE_REGION_NAME', 
                        OFFICE_CODE = '$OFFICE_CODE', 
                        OFFICE_NAME = '$OFFICE_NAME', 
                        CAB_COLL = '$CAB_COLL', 
                        CAB_COLL_NAME = '$CAB_COLL_NAME', 
                        KAPOS_NAME = '$KAPOS_NAME', 
                        PROD_OFFERING_CODE = '$PROD_OFFERING_CODE', 
                        LOB_CODE = '$LOB_CODE', 
                        CUST_TYPE = '$CUST_TYPE', 
                        CUST_NO = '$CUST_NO', 
                        CUST_NAME = '$CUST_NAME', 
                        ID_NO = '$ID_NO', 
                        GENDER = '$GENDER', 
                        RELIGION = '$RELIGION', 
                        BIRTH_PLACE = '$BIRTH_PLACE', 
                        BIRTH_DT = '$BIRTH_DT', 
                        SPOUSE_ID_NO = '$SPOUSE_ID_NO', 
                        SPOUSE_NAME = '$SPOUSE_NAME', 
                        SPOUSE_BIRTH_DT = '$SPOUSE_BIRTH_DT', 
                        ADDR_LEG = '$ADDR_LEG', 
                        RT_LEG = '$RT_LEG', 
                        RW_LEG = '$RW_LEG', 
                        PROVINSI_LEG = '$PROVINSI_LEG', 
                        CITY_LEG = '$CITY_LEG', 
                        KABUPATEN_LEG = '$KABUPATEN_LEG', 
                        KECAMATAN_LEG = '$KECAMATAN_LEG', 
                        KELURAHAN_LEG = '$KELURAHAN_LEG', 
                        ZIPCODE_LEG = '$ZIPCODE_LEG', 
                        SUB_ZIPCODE_LEG = '$SUB_ZIPCODE_LEG', 
                        ADDR_RES = '$ADDR_RES', 
                        RT_RES = '$RT_RES', 
                        RW_RES = '$RW_RES', 
                        PROVINSI_RES = '$PROVINSI_RES', 
                        CITY_RES = '$CITY_RES', 
                        KABUPATEN_RES = '$KABUPATEN_RES', 
                        KECAMATAN_RES = '$KECAMATAN_RES', 
                        KELURAHAN_RES = '$KELURAHAN_RES', 
                        ZIPCODE_RES = '$ZIPCODE_RES', 
                        SUB_ZIPCODE_RES = '$SUB_ZIPCODE_RES', 
                        MOBILE1 = '$MOBILE1', 
                        MOBILE2 = '$MOBILE2', 
                        PHONE1 = '$PHONE1', 
                        PHONE2 = '$PHONE2', 
                        OFFICE_PHONE1 = '$OFFICE_PHONE1', 
                        OFFICE_PHONE2 = '$OFFICE_PHONE2', 
                        PROFESSION_CODE = '$PROFESSION_CODE', 
                        PROFESSION_NAME = '$PROFESSION_NAME', 
                        PROFESSION_CATEGORY_CODE = '$PROFESSION_CATEGORY_CODE', 
                        PROFESSION_CATEGORY_NAME = '$PROFESSION_CATEGORY_NAME', 
                        JOB_POSITION = '$JOB_POSITION', 
                        JOB_STATUS = '$JOB_STATUS', 
                        INDUSTRY_TYPE_NAME = '$INDUSTRY_TYPE_NAME', 
                        OTHER_BIZ_NAME = '$OTHER_BIZ_NAME', 
                        MONTHLY_INCOME = '$MONTHLY_INCOME', 
                        MONTHLY_EXPENSE = '$MONTHLY_EXPENSE', 
                        MONTHLY_INSTALLMENT = '$MONTHLY_INSTALLMENT', 
                        DOWNPAYMENT = '$DOWNPAYMENT', 
                        PERCENT_DP = '$PERCENT_DP', 
                        PLAFOND = '$PLAFOND', 
                        CUST_RATING = '$CUST_RATING', 
                        SUPPL_NAME = '$SUPPL_NAME', 
                        SUPPL_CODE = '$SUPPL_CODE', 
                        MACHINE_NO = '$MACHINE_NO', 
                        CHASSIS_NO = '$CHASSIS_NO', 
                        PRODUCT_CATEGORY = '$PRODUCT_CATEGORY', 
                        ASSET_CATEGORY_CODE = '$ASSET_CATEGORY_CODE', 
                        ASSET_TYPE = '$ASSET_TYPE', 
                        ITEM_BRAND = '$ITEM_BRAND', 
                        ITEM_TYPE = '$ITEM_TYPE', 
                        ITEM_DESCRIPTION = '$ITEM_DESCRIPTION', 
                        ASSET_MODEL = '$ASSET_MODEL', 
                        OTR_PRICE = '$OTR_PRICE', 
                        ITEM_YEAR = '$ITEM_YEAR', 
                        OWNER_RELATIONSHIP = '$OWNER_RELATIONSHIP', 
                        BPKB_OWNERSHIP = '$BPKB_OWNERSHIP', 
                        AGRMNT_RATING = '$AGRMNT_RATING', 
                        CONTRACT_STAT = '$CONTRACT_STAT', 
                        INST_PAYED = '$INST_PAYED', 
                        NEXT_INST_NUM = '$NEXT_INST_NUM', 
                        NEXT_INST_DT = '$NEXT_INST_DT', 
                        OS_TENOR = '$OS_TENOR', 
                        TENOR = '$TENOR', 
                        RELEASE_DATE_BPKB = '$RELEASE_DATE_BPKB', 
                        MATURITY_DT = '$MATURITY_DT', 
                        MATURITY_DURATION = '$MATURITY_DURATION', 
                        GO_LIVE_DT = '$GO_LIVE_DT', 
                        GO_LIVE_DURATION = '$GO_LIVE_DURATION', 
                        AAM_RRD_DT = '$AAM_RRD_DT', 
                        EXPIRED_MONTHS = '$EXPIRED_MONTHS', 
                        OS_PRINCIPAL = '$OS_PRINCIPAL', 
                        OS_PRINCIPAL_AMT = '$OS_PRINCIPAL_AMT', 
                        OS_INTEREST_AMT = '$OS_INTEREST_AMT', 
                        AGING_PEMBIAYAAN = '$AGING_PEMBIAYAAN', 
                        JUMLAH_KONTRAK_PERCUST = '$JUMLAH_KONTRAK_PERCUST', 
                        ESTIMASI_TERIMA_BERSIH = '$ESTIMASI_TERIMA_BERSIH', 
                        STARTED_DT = '$STARTED_DT', 
                        POS_DEALER = '$POS_DEALER', 
                        SALES_DEALER_ID = '$SALES_DEALER_ID', 
                        SALES_DEALER = '$SALES_DEALER', 
                        DTM_CRT = '$DTM_CRT', 
                        USR_CRT = '$USR_CRT', 
                        DTM_UPD = '$DTM_UPD', 
                        USR_UPD = '$USR_UPD', 
                        COLL_AGRMNT_ID = '$COLL_AGRMNT_ID', 
                        AGRMNT_ASSET_ID = '$AGRMNT_ASSET_ID', 
                        ASSET_MASTER_ID = '$ASSET_MASTER_ID', 
                        DEFAULT_STAT = '$DEFAULT_STAT', 
                        CUST_ID = '$CUST_ID', 
                        HOME_STAT = '$HOME_STAT', 
                        MOTHER_NAME = '$MOTHER_NAME', 
                        IS_EVER_REPO = '$IS_EVER_REPO', 
                        IS_REPO = '$IS_REPO', 
                        IS_WRITE_OFF = '$IS_WRITE_OFF', 
                        IS_RESTRUKTUR = '$IS_RESTRUKTUR', 
                        IS_INSURANCE = '$IS_INSURANCE', 
                        IS_NEGATIVE_CUST = '$IS_NEGATIVE_CUST', 
                        IS_ACCOUNT_BAM = '$IS_ACCOUNT_BAM', 
                        CUST_EXPOSURE = '$CUST_EXPOSURE', 
                        AGE = '$AGE', 
                        ASSET_AGE = '$ASSET_AGE', 
                        SAME_ASSET_GO_LIVE = '$SAME_ASSET_GO_LIVE', 
                        LTV = '$LTV', 
                        DSR = '$DSR', 
                        MARITAL_STAT = '$MARITAL_STAT', 
                        EDUCATION = '$EDUCATION', 
                        EMPLOYMENT_ESTABLISHMENT_DT = '$EMPLOYMENT_ESTABLISHMENT_DT', 
                        LENGTH_OF_WORK = '$LENGTH_OF_WORK', 
                        HOUSE_STAY_LENGTH = '$HOUSE_STAY_LENGTH', 
                        LAST_OVERDUE = '$LAST_OVERDUE', 
                        MAX_OVERDUE = '$MAX_OVERDUE', 
                        MAX_OVERDUE_LAST_X_MONTHS = '$MAX_OVERDUE_LAST_X_MONTHS', 
                        IS_USED = '$IS_USED',
                        SPOUSE_BIRTH_PLACE = '$SPOUSE_BIRTH_PLACE',
                        IS_SELECTED = '$IS_SELECTED',
                        PIPELINE_DUMMY_ID = '$PIPELINE_DUMMY_ID',
                        PIPELINE_DUMMY_IS_EARLY_WSC = '$PIPELINE_DUMMY_IS_EARLY_WSC',
                        FINAL_DT = '$FINAL_DT',
                        SPOUSE_PHONE = '$SPOUSE_PHONE',
                        SPOUSE_MOBILE_PHONE_NO = '$SPOUSE_MOBILE_PHONE_NO',
                        GUARANTOR_ID_NO = '$GUARANTOR_ID_NO',
                        GUARANTOR_NAME = '$GUARANTOR_NAME',
                        GUARANTOR_MOBILE_PHONE_NO = '$GUARANTOR_MOBILE_PHONE_NO',
                        GUARANTOR_BIRTH_PLACE = '$GUARANTOR_BIRTH_PLACE',
                        GUARANTOR_BIRTH_DT = '$GUARANTOR_BIRTH_DT',
                        GUARANTOR_ADDR = '$GUARANTOR_ADDR',
                        GUARANTOR_RT = '$GUARANTOR_RT',
                        GUARANTOR_RW = '$GUARANTOR_RW',
                        GUARANTOR_KELURAHAN = '$GUARANTOR_KELURAHAN',
                        GUARANTOR_KECAMATAN = '$GUARANTOR_KECAMATAN',
                        GUARANTOR_CITY = '$GUARANTOR_CITY',
                        GUARANTOR_PROVINSI = '$GUARANTOR_PROVINSI',
                        GUARANTOR_ZIPCODE = '$GUARANTOR_ZIPCODE',
                        GUARANTOR_SUBZIPCODE = '$GUARANTOR_SUBZIPCODE',
                        GUARANTOR_RELATIONSHIP = '$GUARANTOR_RELATIONSHIP',
                        SPOUSE_CUST_ID = '$SPOUSE_CUST_ID',
                        GUARANTOR_CUST_ID = '$GUARANTOR_CUST_ID',
                        opsi_penanganan = '$opsi_penanganan',
                        IS_PRE_APPROVAL = '$IS_PRE_APPROVAL',
                        is_eligible_crm = '1',
                        is_process = '1',
                        is_assign  = '0', 
                        SYNC_TIME=now()
                    ON DUPLICATE KEY UPDATE 
                        campaign_id = '0', 
                        AGRMNT_ID = '$AGRMNT_ID', 
                        AGRMNT_NO = '$AGRMNT_NO', 
                        AGRMNT_DT = '$AGRMNT_DT', 
                        PIPELINE_ID = '$PIPELINE_ID', 
                        JOB_ID = '$JOB_ID', 
                        IS_ACTIVE = '$IS_ACTIVE', 
                        DISTRIBUTED_DT = '$DISTRIBUTED_DT', 
                        DISTRIBUTED_USR = '$DISTRIBUTED_USR', 
                        IS_COMPLETE = '$IS_COMPLETE', 
                        COMPLETED_DT = '$COMPLETED_DT', 
                        CAE_FINAL_SCORE = '$CAE_FINAL_SCORE', 
                        CAE_FINAL_RESULT = '$CAE_FINAL_RESULT', 
                        CAE_RESULT = '$CAE_RESULT', 
                        CAE_DT = '$CAE_DT', 
                        DUKCAPIL = '$DUKCAPIL', 
                        DUKCAPIL_RESULT = '$DUKCAPIL_RESULT', 
                        DUKCAPIL_API_DT = '$DUKCAPIL_API_DT', 
                        SCHEME_ID = '$SCHEME_ID', 
                        SLIK_CBASID = '$SLIK_CBASID', 
                        SLIK_RESULT = '$SLIK_RESULT', 
                        SLIK_CATEGORY = '$SLIK_CATEGORY', 
                        SLIK_API_DT = '$SLIK_API_DT', 
                        SOURCE_DATA = '$SOURCE_DATA', 
                        KILAT_PINTAR = '$KILAT_PINTAR', 
                        BUSINESS_DATE = '$BUSINESS_DATE', 
                        OFFICE_REGION_CODE = '$OFFICE_REGION_CODE', 
                        OFFICE_REGION_NAME = '$OFFICE_REGION_NAME', 
                        OFFICE_CODE = '$OFFICE_CODE', 
                        OFFICE_NAME = '$OFFICE_NAME', 
                        CAB_COLL = '$CAB_COLL', 
                        CAB_COLL_NAME = '$CAB_COLL_NAME', 
                        KAPOS_NAME = '$KAPOS_NAME', 
                        PROD_OFFERING_CODE = '$PROD_OFFERING_CODE', 
                        LOB_CODE = '$LOB_CODE', 
                        CUST_TYPE = '$CUST_TYPE', 
                        CUST_NO = '$CUST_NO', 
                        CUST_NAME = '$CUST_NAME', 
                        ID_NO = '$ID_NO', 
                        GENDER = '$GENDER', 
                        RELIGION = '$RELIGION', 
                        BIRTH_PLACE = '$BIRTH_PLACE', 
                        BIRTH_DT = '$BIRTH_DT', 
                        SPOUSE_ID_NO = '$SPOUSE_ID_NO', 
                        SPOUSE_NAME = '$SPOUSE_NAME', 
                        SPOUSE_BIRTH_DT = '$SPOUSE_BIRTH_DT', 
                        ADDR_LEG = '$ADDR_LEG', 
                        RT_LEG = '$RT_LEG', 
                        RW_LEG = '$RW_LEG', 
                        PROVINSI_LEG = '$PROVINSI_LEG', 
                        CITY_LEG = '$CITY_LEG', 
                        KABUPATEN_LEG = '$KABUPATEN_LEG', 
                        KECAMATAN_LEG = '$KECAMATAN_LEG', 
                        KELURAHAN_LEG = '$KELURAHAN_LEG', 
                        ZIPCODE_LEG = '$ZIPCODE_LEG', 
                        SUB_ZIPCODE_LEG = '$SUB_ZIPCODE_LEG', 
                        ADDR_RES = '$ADDR_RES', 
                        RT_RES = '$RT_RES', 
                        RW_RES = '$RW_RES', 
                        PROVINSI_RES = '$PROVINSI_RES', 
                        CITY_RES = '$CITY_RES', 
                        KABUPATEN_RES = '$KABUPATEN_RES', 
                        KECAMATAN_RES = '$KECAMATAN_RES', 
                        KELURAHAN_RES = '$KELURAHAN_RES', 
                        ZIPCODE_RES = '$ZIPCODE_RES', 
                        SUB_ZIPCODE_RES = '$SUB_ZIPCODE_RES', 
                        MOBILE1 = '$MOBILE1', 
                        MOBILE2 = '$MOBILE2', 
                        PHONE1 = '$PHONE1', 
                        PHONE2 = '$PHONE2', 
                        OFFICE_PHONE1 = '$OFFICE_PHONE1', 
                        OFFICE_PHONE2 = '$OFFICE_PHONE2', 
                        PROFESSION_CODE = '$PROFESSION_CODE', 
                        PROFESSION_NAME = '$PROFESSION_NAME', 
                        PROFESSION_CATEGORY_CODE = '$PROFESSION_CATEGORY_CODE', 
                        PROFESSION_CATEGORY_NAME = '$PROFESSION_CATEGORY_NAME', 
                        JOB_POSITION = '$JOB_POSITION', 
                        JOB_STATUS = '$JOB_STATUS', 
                        INDUSTRY_TYPE_NAME = '$INDUSTRY_TYPE_NAME', 
                        OTHER_BIZ_NAME = '$OTHER_BIZ_NAME', 
                        MONTHLY_INCOME = '$MONTHLY_INCOME', 
                        MONTHLY_EXPENSE = '$MONTHLY_EXPENSE', 
                        MONTHLY_INSTALLMENT = '$MONTHLY_INSTALLMENT', 
                        DOWNPAYMENT = '$DOWNPAYMENT', 
                        PERCENT_DP = '$PERCENT_DP', 
                        PLAFOND = '$PLAFOND', 
                        CUST_RATING = '$CUST_RATING', 
                        SUPPL_NAME = '$SUPPL_NAME', 
                        SUPPL_CODE = '$SUPPL_CODE', 
                        MACHINE_NO = '$MACHINE_NO', 
                        CHASSIS_NO = '$CHASSIS_NO', 
                        PRODUCT_CATEGORY = '$PRODUCT_CATEGORY', 
                        ASSET_CATEGORY_CODE = '$ASSET_CATEGORY_CODE', 
                        ASSET_TYPE = '$ASSET_TYPE', 
                        ITEM_BRAND = '$ITEM_BRAND', 
                        ITEM_TYPE = '$ITEM_TYPE', 
                        ITEM_DESCRIPTION = '$ITEM_DESCRIPTION', 
                        ASSET_MODEL = '$ASSET_MODEL', 
                        OTR_PRICE = '$OTR_PRICE', 
                        ITEM_YEAR = '$ITEM_YEAR', 
                        OWNER_RELATIONSHIP = '$OWNER_RELATIONSHIP', 
                        BPKB_OWNERSHIP = '$BPKB_OWNERSHIP', 
                        AGRMNT_RATING = '$AGRMNT_RATING', 
                        CONTRACT_STAT = '$CONTRACT_STAT', 
                        INST_PAYED = '$INST_PAYED', 
                        NEXT_INST_NUM = '$NEXT_INST_NUM', 
                        NEXT_INST_DT = '$NEXT_INST_DT', 
                        OS_TENOR = '$OS_TENOR', 
                        TENOR = '$TENOR', 
                        RELEASE_DATE_BPKB = '$RELEASE_DATE_BPKB', 
                        MATURITY_DT = '$MATURITY_DT', 
                        MATURITY_DURATION = '$MATURITY_DURATION', 
                        GO_LIVE_DT = '$GO_LIVE_DT', 
                        GO_LIVE_DURATION = '$GO_LIVE_DURATION', 
                        AAM_RRD_DT = '$AAM_RRD_DT', 
                        EXPIRED_MONTHS = '$EXPIRED_MONTHS', 
                        OS_PRINCIPAL = '$OS_PRINCIPAL', 
                        OS_PRINCIPAL_AMT = '$OS_PRINCIPAL_AMT', 
                        OS_INTEREST_AMT = '$OS_INTEREST_AMT', 
                        AGING_PEMBIAYAAN = '$AGING_PEMBIAYAAN', 
                        JUMLAH_KONTRAK_PERCUST = '$JUMLAH_KONTRAK_PERCUST', 
                        ESTIMASI_TERIMA_BERSIH = '$ESTIMASI_TERIMA_BERSIH', 
                        STARTED_DT = '$STARTED_DT', 
                        POS_DEALER = '$POS_DEALER', 
                        SALES_DEALER_ID = '$SALES_DEALER_ID', 
                        SALES_DEALER = '$SALES_DEALER', 
                        DTM_CRT = '$DTM_CRT', 
                        USR_CRT = '$USR_CRT', 
                        DTM_UPD = '$DTM_UPD', 
                        USR_UPD = '$USR_UPD', 
                        COLL_AGRMNT_ID = '$COLL_AGRMNT_ID', 
                        AGRMNT_ASSET_ID = '$AGRMNT_ASSET_ID', 
                        ASSET_MASTER_ID = '$ASSET_MASTER_ID', 
                        DEFAULT_STAT = '$DEFAULT_STAT', 
                        CUST_ID = '$CUST_ID', 
                        HOME_STAT = '$HOME_STAT', 
                        MOTHER_NAME = '$MOTHER_NAME', 
                        IS_EVER_REPO = '$IS_EVER_REPO', 
                        IS_REPO = '$IS_REPO', 
                        IS_WRITE_OFF = '$IS_WRITE_OFF', 
                        IS_RESTRUKTUR = '$IS_RESTRUKTUR', 
                        IS_INSURANCE = '$IS_INSURANCE', 
                        IS_NEGATIVE_CUST = '$IS_NEGATIVE_CUST', 
                        IS_ACCOUNT_BAM = '$IS_ACCOUNT_BAM', 
                        CUST_EXPOSURE = '$CUST_EXPOSURE', 
                        AGE = '$AGE', 
                        ASSET_AGE = '$ASSET_AGE', 
                        SAME_ASSET_GO_LIVE = '$SAME_ASSET_GO_LIVE', 
                        LTV = '$LTV', 
                        DSR = '$DSR', 
                        MARITAL_STAT = '$MARITAL_STAT', 
                        EDUCATION = '$EDUCATION', 
                        EMPLOYMENT_ESTABLISHMENT_DT = '$EMPLOYMENT_ESTABLISHMENT_DT', 
                        LENGTH_OF_WORK = '$LENGTH_OF_WORK', 
                        HOUSE_STAY_LENGTH = '$HOUSE_STAY_LENGTH', 
                        LAST_OVERDUE = '$LAST_OVERDUE', 
                        MAX_OVERDUE = '$MAX_OVERDUE', 
                        MAX_OVERDUE_LAST_X_MONTHS = '$MAX_OVERDUE_LAST_X_MONTHS', 
                        IS_USED = '$IS_USED', 
                        SPOUSE_BIRTH_PLACE = '$SPOUSE_BIRTH_PLACE',
                        IS_SELECTED = '$IS_SELECTED',
                        PIPELINE_DUMMY_ID = '$PIPELINE_DUMMY_ID',
                        PIPELINE_DUMMY_IS_EARLY_WSC = '$PIPELINE_DUMMY_IS_EARLY_WSC',
                        FINAL_DT = '$FINAL_DT',
                        SPOUSE_PHONE = '$SPOUSE_PHONE',
                        SPOUSE_MOBILE_PHONE_NO = '$SPOUSE_MOBILE_PHONE_NO',
                        GUARANTOR_ID_NO = '$GUARANTOR_ID_NO',
                        GUARANTOR_NAME = '$GUARANTOR_NAME',
                        GUARANTOR_MOBILE_PHONE_NO = '$GUARANTOR_MOBILE_PHONE_NO',
                        GUARANTOR_BIRTH_PLACE = '$GUARANTOR_BIRTH_PLACE',
                        GUARANTOR_BIRTH_DT = '$GUARANTOR_BIRTH_DT',
                        GUARANTOR_ADDR = '$GUARANTOR_ADDR',
                        GUARANTOR_RT = '$GUARANTOR_RT',
                        GUARANTOR_RW = '$GUARANTOR_RW',
                        GUARANTOR_KELURAHAN = '$GUARANTOR_KELURAHAN',
                        GUARANTOR_KECAMATAN = '$GUARANTOR_KECAMATAN',
                        GUARANTOR_CITY = '$GUARANTOR_CITY',
                        GUARANTOR_PROVINSI = '$GUARANTOR_PROVINSI',
                        GUARANTOR_ZIPCODE = '$GUARANTOR_ZIPCODE',
                        GUARANTOR_SUBZIPCODE = '$GUARANTOR_SUBZIPCODE',
                        GUARANTOR_RELATIONSHIP = '$GUARANTOR_RELATIONSHIP',
                        SPOUSE_CUST_ID = '$SPOUSE_CUST_ID',
                        GUARANTOR_CUST_ID = '$GUARANTOR_CUST_ID',
                        opsi_penanganan = '$opsi_penanganan',
                        IS_PRE_APPROVAL = '$IS_PRE_APPROVAL',
                        is_eligible_crm = '1',
                        is_process = '1', 
                        is_assign  = '0', 
                        SYNC_TIME=now()";
        $stmt =  $dbopen->prepare($sql_in2);
        $resin2 = $stmt->execute();
        $stmt->close();
    }

            $sqldelete = "DELETE FROM cc_ts_penawaran_job  
                             WHERE campaign_id='0' AND SOURCE_DATA = 'WISE'"; 
            $stmt =  $dbopen->prepare($sqldelete);
            $resdelete = $stmt->execute();
            $stmt->close();
           

disconnectDB($dbopen);


mssql_close($con);


?>
