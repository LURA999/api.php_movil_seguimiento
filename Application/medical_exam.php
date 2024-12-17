<?php
require '../Config/database.php';

class medical_exam extends database {
    
    function get_allExamList($input) {
       $sql = $this->connect()->prepare('
        SELECT `idExam`,numEmployee, name, datetime_modification, examName 
        FROM medical_prIn_det_exam as mpde
        INNER JOIN medical_prIn_init_or_pre p ON fk_InitOrPre = p.idInitOrPre 
        INNER JOIN medical_prIn_personal_file pf ON fk_personalLife = pf.idPersonal 
        INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr LEFT JOIN exam_name on idExamName = type 
        WHERE mpde.local = :local 
        ORDER BY idExam ASC LIMIT 10 OFFSET 0;
       ');
       $sql->bindParam(':local',$input[0],PDO::PARAM_INT);
       $sql ->execute();
       return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //IMPRIMIENDO TODA LA INFORMACION QUE NO SEA REDUNDANTE (ES DECIR QUE NO SE DESPLAZCA EN MAS DE UNA FILA)
    function get_examAccidentDisease($input) {
       $sql = $this->connect()->prepare('SELECT company, date, position, disease_name, number_d_incapacity, causa, incapacity 
       FROM `medical_prIn_acciddent_disease` INNER JOIN exams ON fk_initial_pre_entry = fk_idExam WHERE idExam = :idExam;');
       $sql->bindParam(':idExam',$input[0],PDO::PARAM_INT);
       $sql ->execute();
       return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function get_examHeredityFam($input) {
       $sql = $this->connect()->prepare('SELECT  good_health, bad_health, deceased, allergy, diabetes, high_persion, cholesterol, heart_disease, cancer, anemia 
       FROM `medical_prIn_heredity_fam` INNER JOIN exams ON fk_initial_pre_entry = fk_idExam WHERE idExam = :idExam;');
       $sql->bindParam(':idExam',$input[0],PDO::PARAM_INT);
       $sql ->execute();
       return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function get_examHistory($input) {
       $sql = $this->connect()->prepare('SELECT company, position, time, when_left, job_rotation, solvent_chemical, fume, vapor, dust, noisy, material_load 
       FROM `medical_prIn_history` INNER JOIN exams ON fk_initial_pre_entry = fk_idExam WHERE idExam = :idExam;');
       $sql->bindParam(':idExam',$input[0],PDO::PARAM_INT);
       $sql ->execute();
       return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
     function get_examOneInformationPart1($input) {
       $sql = $this->connect()->prepare('SELECT
        /*`idExam`,*/
        /*`idDetExamInPr`,*/
        /*`datetime_modification`,*/
        /*`fk_InitOrPre`,*/ date_exam, `numEmployee`, `departament`, `place`, /*`type`,*/
        /*`fk_personalLife`,*/ `name`, `sex`, `age`, `marital_status`, `address`, `tel_cel`, `place_birthday`,
        `date_birthday`, `extra_activity`, `schooling`, `college_career`, `number_children`,
        /*`fk_heredityPers`, `fk_dominant_hand`, `dominant`, `smoking`,*/ `age_smoking`, `amount_cigarettes`, 
        /*`alcohol`, */`age_alcohol`, `often_alcohol`, /*`taxonomists`, */`age_taxonomists`, `often_taxonomists`, 
        /*`allergy_medicament`, */`what_medicament`, /*`allergy_food`, */`what_food`, /*`covid_vaccine`, `tetanus_vaccine`,
        `hepatitis_vaccine`, `pneumococcal_vaccine`, */`other_vaccine`, /*`practice_exercise`, */`what_exercise`, 
        `often_exercise`, /*`idGynecologist`, */`age_fmenstruation`, `age_stSex_life`, `amount_pregnancy`, `amount_childbirth`, 
        `cesarean`, `abort`, `last_rule_date`, prg.rhythm, /*`fk_contraceptive_method`,*/ `date_last_pap_smear`, `result_pap_smear`, 
        `mammography_date`, `result_mammography`, `lactation`, /*`fk_idHeredityPers`,*/
        /*`fk_patalogicalPersBack`, `arthritis`, `asthma`, `bronchitis`, `hepatitis`, `covid`, `kidney_disease`, 
        `skin_disease`, `thyreous_disease`, `hernia`, `low_back_pain`, `diabetes`, `gastitris`, `gynaecological`, 
        `hemorrhoid`, `ulcer`, `varices`, hypertension, `pneumonia`, `tuberculosis`, `colitis`, `depression`, */`other_disease`, 
        /*`hospitalization`, */`reason_hospitalization`, /*`surgery`, */`reason_surgery`, /*`transfusion`, */`reason_transfusion`, 
        /*`trauma_fracture`, */`what_trauma_fracture`, /*`complication`, */`what_complication`, /*`chronic_disease`, */`what_chronic`, 
        `current_treatment`, `signature_patient`,
        /*`fk_apparatusSystem`,*/ `sense`, `digestive`, `respiratory`, `circulatory`, `genitourinary`, `muscle_skeletal`, `nervous`,
        /*`fk_physicalExploration`,*/ `t_a`, `f_c`, `weight`, `height`, `p_abd`, `f_r`, `temp`, `i_m_c`, /*`general_dln`,*/ 
        `attitude`, `march`, `appearence`, `edo_animo`, /*`ear_dln`, */`ear_d`, `ear_i`, `cae_d`, `cae_i`, `eardrum_d`, `eardrum_i`, 
        /*`head_dln`, */`hair`, `surface`, `shape`, `breast_pn`, /*`eye_dln`, */`reflex`, `pupil`, `back_eye`, `pterigion_d`, `pterigion_i`, 
        /*`neuro_dln`, */`reflex_ot`, `romberg`, `heel_knee`, /*`mouth_dln`, */`lip`, `breath`,  `tongue`, `pharynx`, `amygdala`, `tooth`, 
        `mucosa`, /*`thorax_dln`, */`shape_thorax`, `diaphragm`, `rub_thorax`, `ventilation_thorax`, `rales`, /*`abdomen_dln`,*/ 
        `shape_abdomen`, `pain`, `mass`, `hernia_d`, `hernia_i`, /*`nose_dln`, */`septum`, `mucosa_d`, `mucosa_i`, `ventilation_nose`, 
        /*`precordial_area_dln`, */`often`,phy.rhythm rhythm_precordial, `tones`, `rub_precordial`, `puff_precordial`, /*`skin_dln`, */`scar`, `texture`, 
        `diaphoresis`, `other_injury`, /*`extremity_dln`, */`articulate_ext_d`, `articulate_ext_i`, `muscular_ext_d`, `muscular_ext_i`, 
        `nervous_ext_d`, `nervous_ext_i`, `articulate_mi_d`, `articulate_mi_i`, `muscular_mi_d`, `mucular_mi_i`, `nervous_mi_d`, 
        `nervous_mi_i`, `str_column`, /*`idEyes`, `near_30cm`, */`od_rosenbaun`, `oi_rosenbaun`, `od_jaeguer`, `oi_jaeguer`, /*`far_glasses`, */`od_snellen`, `oi_snellen`, `od_campimetry`, `oi_campimetry`, `color_campimetry`, /*`amsler_normal`,*/ 
        /*`fk_laboratoryTest`, */`result`, `drug`, 
        /*`fk_imagingStudy`, */`thorax_radiograph`, `rx_lumbar_spine`, /*`spirometry`, `audiometry`, `covid_test`, `pregnancy`, `antidoping`,*/
        `suitable`,
        `not_suitable`,
        `suitable_more`,
        `condition_observation`,
        `doctor_signature`,
        `applicant_signature`,
        /*RadioButton*/
        `type`, `smoking`, 
        `alcohol`, `taxonomists`, `allergy_medicament`, 
        `allergy_food`, `covid_vaccine`, `tetanus_vaccine`,
        `hepatitis_vaccine`, `pneumococcal_vaccine`, `practice_exercise`, 
         `arthritis`, `asthma`, 
        `bronchitis`, `hepatitis`, `covid`, 
        `kidney_disease`, `skin_disease`, `thyreous_disease`, 
        `hernia`, `low_back_pain`, `diabetes`, 
        `gastitris`, `gynaecological`, `hemorrhoid`, 
        `ulcer`, `varices`, `hypertension`, `pneumonia`, 
        `tuberculosis`, `colitis`, `depression`, 
        `hospitalization`, `surgery`, `transfusion`,
        `trauma_fracture`, `complication`, `chronic_disease`, 
        `near_30cm`, `far_glasses`, `amsler_normal`, 
        `spirometry`, `audiometry`, `covid_test`, 
        `antidoping`, `pregnancy`, 
        /*checkbox*/
         general_dln, ear_dln,  head_dln,  eye_dln,  neuro_dln, mouth_dln,  thorax_dln,  
         abdomen_dln,  nose_dln,  precordial_area_dln,  skin_dln,  extremity_dln,
        /* radiobutton hand*/
        `fk_dominant_hand`, 
        /* radiobutton method*/
        `fk_contraceptive_method`
        FROM
        `medical_prIn_det_exam` mpde
        LEFT JOIN exams ex ON ex.fk_initial_pre_entry = idDetExamInPr
        LEFT JOIN medical_prIn_init_or_pre pr ON pr.idInitOrPre = fk_InitOrPre
        LEFT JOIN medical_prIn_personal_file f ON f.idPersonal = fk_personalLife
        LEFT JOIN medical_prIn_heredity_pers p ON p.idHeredityPers = fk_heredityPers
        LEFT JOIN medical_prIn_pata_pers_back b ON b.idPatalogicalPersBack = fk_patalogicalPersBack
        LEFT JOIN medical_prIn_apparatus_sys sy ON sy.idAparattusSystem = fk_apparatusSystem
        LEFT JOIN medical_prIn_phy_exploration phy ON phy.idExploration = fk_physicalExploration
        LEFT JOIN medical_prIn_laboratory_test lab ON lab.idLaboratoryTest = fk_laboratoryTest
        LEFT JOIN medical_prIn_imaging_study im ON im.idImagingStudy = fk_imagingStudy
        LEFT JOIN medical_prIn_gynecologist_back prg ON prg.fk_idHeredityPers  = idHeredityPers
        LEFT JOIN dominant_hand dom ON dom.idHand = fk_dominant_hand
        LEFT JOIN medical_prIn_phy_eyes phey ON phey.fk_idExploration =  phy.idExploration
        WHERE idExam = :idExam AND mpde.local = :local;');
       $sql->bindParam(':idExam',$input[0],PDO::PARAM_INT);
       $sql->bindParam(':local',$input[1],PDO::PARAM_INT);
       $sql ->execute();
       return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //A CONTINUACION SE MUESTRAN TODOS LOS POST A LAS TABLAS INDIVIDUALES
     function post_examMain($input) {
        $sql = $this->connect()->prepare("
            INSERT INTO `exams`(`numEmployee`, `fk_initial_pre_entry`) VALUES ( :numEmployee, :fk_initial_pre_entry)
        ");
        
        $sql->bindParam(':numEmployee', $input['numEmployee'] ,PDO::PARAM_INT);
        $sql->bindParam(':fk_initial_pre_entry', $input['fk_initial_pre_entry'] ,PDO::PARAM_INT);
        return $sql ->execute();
    }
    
    function post_examDetail($input) {
        $connection = $this->connect();
        
        if($input['fk_InitOrPre'] != "" && isset($input['fk_InitOrPre'])){
            $fk_InitOrPre = ',:fk_InitOrPre';
            $c_fk_InitOrPre = ', `fk_InitOrPre`';
        }
        
        if($input['fk_personalLife'] != "" && isset($input['fk_personalLife'])){
            $fk_personalLife = ',:fk_personalLife';
            $c_fk_personalLife = ', `fk_personalLife`';
        }
        
        
        if($input['fk_heredetyBack'] != "" && isset($input['fk_heredetyBack'])){
            $fk_heredetyBack = ',:fk_heredetyBack';
            $c_fk_heredetyBack = ', `fk_heredetyBack`';
        }
        
        if($input['fk_heredityPers'] != "" && isset($input['fk_heredityPers'])){
            $fk_heredityPers = ',:fk_heredityPers';
            $c_fk_heredityPers = ', `fk_heredityPers`';
        }
        
        if($input['fk_patalogicalPersBack'] != "" && isset($input['fk_patalogicalPersBack'])){
            $fk_patalogicalPersBack = ',:fk_patalogicalPersBack';
            $c_fk_patalogicalPersBack = ', `fk_patalogicalPersBack`';
        }
        
        if($input['fk_apparatusSystem'] != "" && isset($input['fk_apparatusSystem'])){
            $fk_apparatusSystem = ',:fk_apparatusSystem';
            $c_fk_apparatusSystem = ', `fk_apparatusSystem`';
        }
        
        if($input['fk_physicalExploration'] != "" && isset($input['fk_physicalExploration'])){
            $fk_physicalExploration = ',:fk_physicalExploration';
            $c_fk_physicalExploration = ', `fk_physicalExploration`';
        }
        
        if($input['fk_laboratoryTest'] != "" && isset($input['fk_laboratoryTest'])){
            $fk_laboratoryTest = ',:fk_laboratoryTest';
            $c_fk_laboratoryTest = ', `fk_laboratoryTest`';
        }
        
        if($input['fk_imagingStudy'] != "" && isset($input['fk_imagingStudy'])){
            $fk_imagingStudy = ',:fk_imagingStudy';
            $c_fk_imagingStudy = ', `fk_imagingStudy`';
        }
        
        if($input['suitable'] != "" && isset($input['suitable'])){
            $suitable = ',:suitable';
            $c_suitable = ', `suitable`';
        }
        
        if($input['not_suitable'] != "" && isset($input['not_suitable'])){
            $not_suitable = ',:not_suitable';
            $c_not_suitable = ', `not_suitable`';
        }
        
        if($input['suitable_more'] != "" && isset($input['suitable_more'])){
            $suitable_more = ',:suitable_more';
            $c_suitable_more = ', `suitable_more`';
        }
        
        if($input['condition_observation'] != "" && isset($input['condition_observation'])){
            $condition_observation = ',:condition_observation';
            $c_condition_observation = ', `condition_observation`';
        }
        
        if($input['applicant_signature'] != "" && isset($input['applicant_signature'])){
            $applicant_signature = ',:applicant_signature';
            $c_applicant_signature = ', `applicant_signature`';
        }
        
        if($input['doctor_signature'] != "" && isset($input['doctor_signature'])){
            $doctor_signature = ',:doctor_signature';
            $c_doctor_signature = ', `doctor_signature`';
        }
        
        
        
        
        $sql = $connection->prepare("
        INSERT INTO `medical_prIn_det_exam`(`datetime_modification`$c_fk_InitOrPre $c_fk_personalLife $c_fk_heredetyBack 
        $c_fk_heredityPers $c_fk_patalogicalPersBack $c_fk_apparatusSystem $c_fk_physicalExploration $c_fk_laboratoryTest $c_fk_imagingStudy $c_suitable $c_not_suitable 
        $c_suitable_more $c_condition_observation $c_applicant_signature $c_doctor_signature, local) 
        VALUES ( NOW() $fk_InitOrPre $fk_personalLife $fk_heredetyBack $fk_heredityPers 
        $fk_patalogicalPersBack $fk_apparatusSystem $fk_physicalExploration $fk_laboratoryTest $fk_imagingStudy $suitable $not_suitable $suitable_more 
        $condition_observation $applicant_signature $doctor_signature, :local)
        ");
        
        $sql->bindParam(':local', $input['local']);
        
        if($input['fk_InitOrPre'] != "" && isset($input['fk_InitOrPre'])){
        $sql->bindParam(':fk_InitOrPre', $input['fk_InitOrPre'] ,PDO::PARAM_INT);       
        }
        
        if($input['fk_personalLife'] != "" && isset($input['fk_personalLife'])){
        $sql->bindParam(':fk_personalLife', $input['fk_personalLife'] ,PDO::PARAM_STR);
        }
        
        if($input['fk_heredetyBack'] != "" && isset($input['fk_heredetyBack'])){
        $sql->bindParam(':fk_heredetyBack', $input['fk_heredetyBack'] ,PDO::PARAM_STR);
        }
        
        if($input['fk_heredityPers'] != "" && isset($input['fk_heredityPers'])){
        $sql->bindParam(':fk_heredityPers', $input['fk_heredityPers'] ,PDO::PARAM_STR);
        }
        
        if($input['fk_patalogicalPersBack'] != "" && isset($input['fk_patalogicalPersBack'])){
        $sql->bindParam(':fk_patalogicalPersBack', $input['fk_patalogicalPersBack'] ,PDO::PARAM_STR);
        }
        
        if($input['fk_apparatusSystem'] != "" && isset($input['fk_apparatusSystem'])){
        $sql->bindParam(':fk_apparatusSystem', $input['fk_apparatusSystem'] ,PDO::PARAM_STR);
        }
        
        if($input['fk_physicalExploration'] != "" && isset($input['fk_physicalExploration'])){
        $sql->bindParam(':fk_physicalExploration', $input['fk_physicalExploration'] ,PDO::PARAM_STR);
        }
        
        if($input['fk_laboratoryTest'] != "" && isset($input['fk_laboratoryTest'])){
        $sql->bindParam(':fk_laboratoryTest', $input['fk_laboratoryTest'] ,PDO::PARAM_STR);
        }
        
        if($input['fk_imagingStudy'] != "" && isset($input['fk_imagingStudy'])){
        $sql->bindParam(':fk_imagingStudy', $input['fk_imagingStudy'] ,PDO::PARAM_STR);
        }
        
        if($input['suitable'] != "" && isset($input['suitable'])){
        $sql->bindParam(':suitable', $input['suitable'] ,PDO::PARAM_STR);
        }
        
        if($input['not_suitable'] != "" && isset($input['not_suitable'])){
        $sql->bindParam(':not_suitable', $input['not_suitable'] ,PDO::PARAM_STR);
        }
        
        if($input['suitable_more'] != "" && isset($input['suitable_more'])){
        $sql->bindParam(':suitable_more', $input['suitable_more'] ,PDO::PARAM_STR);
        }
        
        if($input['condition_observation'] != "" && isset($input['condition_observation'])){
        $sql->bindParam(':condition_observation', $input['condition_observation'] ,PDO::PARAM_STR);
        }
        
        if($input['applicant_signature'] != "" && isset($input['applicant_signature'])){
        $sql->bindParam(':applicant_signature', $input['applicant_signature'] ,PDO::PARAM_STR);
        }
        
        if($input['doctor_signature'] != "" && isset($input['doctor_signature'])){
        $sql->bindParam(':doctor_signature', $input['doctor_signature'] ,PDO::PARAM_STR);
        }
        
        
        if ($sql->execute()) {
            $lastInsertedId = $connection->lastInsertId();
            return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
        }
    }
    
    function post_examAccident($input) {
       $sql = $this->connect()->prepare("
            INSERT INTO `medical_prIn_acciddent_disease`(`company`, `date`, `position`, `causa`, `disease_name`, `incapacity`, `number_d_incapacity`, `idFake`, `fk_idExam`) 
            VALUES (:company, :date, :position, :causa, :disease_name, :incapacity, :number_d_incapacity, :idFake, :fk_idExam);
        ");
        $sql->bindParam(':company', $input['company'] ,PDO::PARAM_STR);
        $sql->bindParam(':date', $input['date'] ,PDO::PARAM_STR);
        $sql->bindParam(':position', $input['position'] ,PDO::PARAM_STR);
        $sql->bindParam(':causa', $input['causa'] ,PDO::PARAM_STR);
        $sql->bindParam(':disease_name', $input['disease_name'] ,PDO::PARAM_STR);
        $sql->bindParam(':incapacity', $input['incapacity'] ,PDO::PARAM_STR);
        $sql->bindParam(':number_d_incapacity', $input['number_d_incapacity'] ,PDO::PARAM_STR);
        $sql->bindParam(':fk_idExam', $input['fk_idExam'] ,PDO::PARAM_STR);
        $sql->bindParam(':idFake', $input['idFake'] ,PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function post_examApparatusSys($input) {
        $connection = $this->connect();
        $sql = $connection->prepare("
            INSERT INTO `medical_prIn_apparatus_sys`(`sense`, `digestive`, `respiratory`, `circulatory`, `genitourinary`, `muscle_skeletal`, `nervous`) 
            VALUES (:sense, :digestive, :respiratory, :circulatory, :genitourinary, :muscle_skeletal, :nervous)
        ");
        $sql->bindParam(':sense', $input['sense'] ,PDO::PARAM_STR);
        $sql->bindParam(':digestive', $input['digestive'] ,PDO::PARAM_STR);
        $sql->bindParam(':respiratory', $input['respiratory'] ,PDO::PARAM_STR);
        $sql->bindParam(':circulatory', $input['circulatory'] ,PDO::PARAM_STR);
        $sql->bindParam(':genitourinary', $input['genitourinary'] ,PDO::PARAM_STR);
        $sql->bindParam(':muscle_skeletal', $input['muscle_skeletal'] ,PDO::PARAM_STR);
        $sql->bindParam(':nervous', $input['nervous'] ,PDO::PARAM_STR);
         if ($sql->execute()) {
            $lastInsertedId = $connection->lastInsertId();
            return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
        }
    }
    
    function post_examGynecologistBack($input) {
        $sql = $this->connect()->prepare("
        INSERT INTO `medical_prIn_gynecologist_back`(`age_fmenstruation`, `age_stSex_life`, `amount_pregnancy`, `amount_childbirth`, `cesarean`, `abort`, 
        `last_rule_date`, `rhythm`, `fk_contraceptive_method`, `date_last_pap_smear`, `result_pap_smear`, `mammography_date`, `result_mammography`, `lactation`, `fk_idHeredityPers`) 
        VALUES (:age_fmenstruation, :age_stSex_life, :amount_pregnancy, :amount_childbirth, :cesarean, :abort, :last_rule_date, :rhythm, :fk_contraceptive_method, 
        :date_last_pap_smear, :result_pap_smear, :mammography_date, :result_mammography, :lactation, :fk_idHeredityPers) 
        ");
        $sql->bindParam(':age_fmenstruation', $input['age_fmenstruation'] ,PDO::PARAM_STR);
        $sql->bindParam(':age_stSex_life', $input['age_stSex_life'] ,PDO::PARAM_STR);
        $sql->bindParam(':amount_pregnancy', $input['amount_pregnancy'] ,PDO::PARAM_STR);
        $sql->bindParam(':amount_childbirth', $input['amount_childbirth'] ,PDO::PARAM_STR);
        $sql->bindParam(':cesarean', $input['cesarean'] ,PDO::PARAM_STR);
        $sql->bindParam(':abort', $input['abort'] ,PDO::PARAM_STR);
        $sql->bindParam(':last_rule_date', $input['last_rule_date'] ,PDO::PARAM_STR);
        $sql->bindParam(':rhythm', $input['rhythm'] ,PDO::PARAM_STR);
        $sql->bindParam(':fk_contraceptive_method', $input['fk_contraceptive_method'] ,PDO::PARAM_STR);
        $sql->bindParam(':fk_idHeredityPers', $input['fk_idHeredityPers'] ,PDO::PARAM_INT);
        $sql->bindParam(':date_last_pap_smear', $input['date_last_pap_smear'] ,PDO::PARAM_STR);
        $sql->bindParam(':result_pap_smear', $input['result_pap_smear'] ,PDO::PARAM_STR);
        $sql->bindParam(':mammography_date', $input['mammography_date'] ,PDO::PARAM_STR);
        $sql->bindParam(':result_mammography', $input['result_mammography'] ,PDO::PARAM_STR);
        $sql->bindParam(':lactation', $input['lactation'] ,PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function post_examHeredityFam($input) {
        $connection = $this->connect();
        
        $sql = $connection->prepare("
        INSERT INTO `medical_prIn_heredity_fam`(`good_health`, `bad_health`, `deceased`, `allergy`, `diabetes`, `high_persion`, `cholesterol`, 
        `heart_disease`, `cancer`, `anemia`, `fk_category_hef`, `fk_idExam`) 
        VALUES ( :good_health, :bad_health, :deceased, :allergy, :diabetes, :high_persion, :cholesterol, :heart_disease,
        :cancer, :anemia, :fk_category_hef, :fk_idExam)
        ");
        $sql->bindParam(':good_health', $input[0] ,PDO::PARAM_INT);
        $sql->bindParam(':bad_health', $input[1] ,PDO::PARAM_INT);
        $sql->bindParam(':deceased', $input[2] ,PDO::PARAM_INT);
        $sql->bindParam(':allergy', $input[3] ,PDO::PARAM_INT);
        $sql->bindParam(':diabetes', $input[4] ,PDO::PARAM_INT);
        $sql->bindParam(':high_persion', $input[5] ,PDO::PARAM_INT);
        $sql->bindParam(':cholesterol', $input[6] ,PDO::PARAM_INT);
        $sql->bindParam(':heart_disease', $input[7] ,PDO::PARAM_INT);
        $sql->bindParam(':cancer', $input[8] ,PDO::PARAM_INT);
        $sql->bindParam(':anemia', $input[9] ,PDO::PARAM_INT);
        $sql->bindParam(':fk_category_hef', $input[10] ,PDO::PARAM_INT);
        $sql->bindParam(':fk_idExam', $input[11] ,PDO::PARAM_INT);
        
        if ($sql->execute()) {
            $lastInsertedId = $connection->lastInsertId();
            return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
        }
    }
    
    function post_examHeredityPers($input) {
        $connection = $this->connect();
        $sql = $connection->prepare("
        INSERT INTO `medical_prIn_heredity_pers`(`fk_dominant_hand`, `smoking`, `age_smoking`, `amount_cigarettes`, `alcohol`, `age_alcohol`, `often_alcohol`
        , `taxonomists`, `age_taxonomists`, `often_taxonomists`, `allergy_medicament`, `what_medicament`, `allergy_food`, `what_food`, `covid_vaccine`, `tetanus_vaccine`, `hepatitis_vaccine`
        , `pneumococcal_vaccine`, `other_vaccine`, `practice_exercise`, `what_exercise`, `often_exercise`) 
        VALUES (:fk_dominant_hand, :smoking, :age_smoking, :amount_cigarettes, :alcohol, :age_alcohol, :often_alcohol, 
        :taxonomists, :age_taxonomists, :often_taxonomists, :allergy_medicament, :what_medicament, :allergy_food, :what_food, :covid_vaccine, :tetanus_vaccine, :hepatitis_vaccine, 
        :pneumococcal_vaccine, :other_vaccine, :practice_exercise, :what_exercise, :often_exercise)
        ");
        $sql->bindParam(':fk_dominant_hand', $input['fk_dominant_hand'] ,PDO::PARAM_STR);
        $sql->bindParam(':smoking', $input['smoking'] ,PDO::PARAM_STR);
        $sql->bindParam(':age_smoking', $input['age_smoking'] ,PDO::PARAM_STR);
        $sql->bindParam(':amount_cigarettes', $input['amount_cigarettes'] ,PDO::PARAM_STR);
        $sql->bindParam(':alcohol', $input['alcohol'] ,PDO::PARAM_STR);
        $sql->bindParam(':age_alcohol', $input['age_alcohol'] ,PDO::PARAM_STR);
        $sql->bindParam(':often_alcohol', $input['often_alcohol'] ,PDO::PARAM_STR);
        $sql->bindParam(':taxonomists', $input['taxonomists'] ,PDO::PARAM_STR);
        $sql->bindParam(':age_taxonomists', $input['age_taxonomists'] ,PDO::PARAM_STR);
        $sql->bindParam(':often_taxonomists', $input['often_taxonomists'] ,PDO::PARAM_STR);
        $sql->bindParam(':allergy_medicament', $input['allergy_medicament'] ,PDO::PARAM_STR);
        $sql->bindParam(':what_medicament', $input['what_medicament'] ,PDO::PARAM_STR);
        $sql->bindParam(':allergy_food', $input['allergy_food'] ,PDO::PARAM_STR);
        $sql->bindParam(':what_food', $input['what_food'] ,PDO::PARAM_STR);
        $sql->bindParam(':covid_vaccine', $input['covid_vaccine'] ,PDO::PARAM_STR);
        $sql->bindParam(':tetanus_vaccine', $input['tetanus_vaccine'] ,PDO::PARAM_STR);
        $sql->bindParam(':hepatitis_vaccine', $input['hepatitis_vaccine'] ,PDO::PARAM_STR);
        $sql->bindParam(':pneumococcal_vaccine', $input['pneumococcal_vaccine'] ,PDO::PARAM_STR);
        $sql->bindParam(':other_vaccine', $input['other_vaccine'] ,PDO::PARAM_STR);
        $sql->bindParam(':practice_exercise', $input['practice_exercise'] ,PDO::PARAM_STR);
        $sql->bindParam(':what_exercise', $input['what_exercise'] ,PDO::PARAM_STR);
        $sql->bindParam(':often_exercise', $input['often_exercise'] ,PDO::PARAM_STR);
        
         if ($sql->execute()) {
            $lastInsertedId = $connection->lastInsertId();
            return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
        }
    }
    
    function post_examHistory($input) {
        $sql = $this->connect()->prepare("
            INSERT INTO `medical_prIn_history`(`company`, `position`, `time`, `when_left`, `job_rotation`, `solvent_chemical`, `fume`, `vapor`, `dust`, 
            `noisy`, `material_load`, `idFake`, `fk_idExam`) 
            VALUES (:company, :position, :time, :when_left, :job_rotation, :solvent_chemical, :fume, :vapor, :dust, :noisy, :material_load, :idFake, :fk_idExam)
        ");
        $sql->bindParam(':company', $input['company'] ,PDO::PARAM_STR);
        $sql->bindParam(':position', $input['position'] ,PDO::PARAM_STR);
        $sql->bindParam(':time', $input['time'] ,PDO::PARAM_STR);
        $sql->bindParam(':when_left', $input['when_left'] ,PDO::PARAM_STR);
        $sql->bindParam(':job_rotation', $input['job_rotation'] ,PDO::PARAM_STR);
        $sql->bindParam(':solvent_chemical', $input['solvent_chemical'] ,PDO::PARAM_STR);
        $sql->bindParam(':fume', $input['fume'] ,PDO::PARAM_STR);
        $sql->bindParam(':vapor', $input['vapor'] ,PDO::PARAM_STR);
        $sql->bindParam(':dust', $input['dust'] ,PDO::PARAM_STR);
        $sql->bindParam(':noisy', $input['noisy'] ,PDO::PARAM_STR);
        $sql->bindParam(':material_load', $input['material_load'] ,PDO::PARAM_STR);
        $sql->bindParam(':idFake', $input['idFake'] ,PDO::PARAM_INT);
        $sql->bindParam(':fk_idExam', $input['fk_idExam'] ,PDO::PARAM_INT);
        return $sql ->execute();
    }
    
    function post_examImagingStudy($input) {
        $connection = $this->connect();
        $sql = $connection->prepare("
            INSERT INTO `medical_prIn_imaging_study`(`thorax_radiograph`, `rx_lumbar_spine`, `spirometry`, `audiometry`, `covid_test`, `antidoping`, `pregnancy`) 
            VALUES (:thorax_radiograph, :rx_lumbar_spine, :spirometry, :audiometry, :covid_test, :antidoping, :pregnancy)
        ");
        $sql->bindParam(':thorax_radiograph', $input['thorax_radiograph'] ,PDO::PARAM_STR);
        $sql->bindParam(':rx_lumbar_spine', $input['rx_lumbar_spine'] ,PDO::PARAM_STR);
        $sql->bindParam(':spirometry', $input['spirometry'] ,PDO::PARAM_STR);
        $sql->bindParam(':audiometry', $input['audiometry'] ,PDO::PARAM_STR);
        $sql->bindParam(':covid_test', $input['covid_test'] ,PDO::PARAM_STR);
        $sql->bindParam(':pregnancy', $input['pregnancy'] ,PDO::PARAM_STR);
        $sql->bindParam(':antidoping', $input['antidoping'] ,PDO::PARAM_STR);
        
        if ($sql->execute()) {
            $lastInsertedId = $connection->lastInsertId();
            return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
        }
    }
    
    function post_examLaboratoryTest($input) {
        $connection = $this->connect();
        $sql = $connection->prepare("
            INSERT INTO `medical_prIn_laboratory_test`(`result`, `drug`) 
            VALUES ( :result, :drug)
        ");
        $sql->bindParam(':result',$input['result'],PDO::PARAM_STR);
        $sql->bindParam(':drug',$input['drug'],PDO::PARAM_STR);
        if ($sql->execute()) {
            $lastInsertedId = $connection->lastInsertId();
            return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
        }
    }
    
    function post_examInitPre($input) {
        $connection = $this->connect();
        $sql = $connection->prepare("
            INSERT INTO `medical_prIn_init_or_pre`(`departament`, `place`, `type`) 
            VALUES (:departament, :place, :type)
        ");
        $sql->bindParam(':departament',$input['departament'],PDO::PARAM_INT);
        $sql->bindParam(':place',$input['place'],PDO::PARAM_STR);
        $sql->bindParam(':type',$input['type'],PDO::PARAM_INT);
        
        if ($sql->execute()) {
            $lastInsertedId = $connection->lastInsertId();
            return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
        }

        return $sql ->execute();
    }
    
    function post_examPataPersBack($input) {
        $connection = $this->connect();
        $sql = $connection->prepare("
        INSERT INTO `medical_prIn_pata_pers_back`(`arthritis`, `asthma`, `bronchitis`, `hepatitis`, `covid`, `kidney_disease`, `skin_disease`, `thyreous_disease`, `hernia`,
        `low_back_pain`, `diabetes`, `gastitris`, `gynaecological`, `hemorrhoid`, `ulcer`, `varices`, `pneumonia`, `tuberculosis`, `colitis`, `depression`, `other_disease`, `hospitalization`,
        `reason_hospitalization`, `surgery`, `reason_surgery`, `transfusion`, `reason_transfusion`, `trauma_fracture`, `what_trauma_fracture`, `complication`, `what_complication`, `chronic_disease`,
        `what_chronic`, `current_treatment`,hypertension, signature_patient) 
        VALUES (:arthritis ,:asthma ,:bronchitis ,:hepatitis, :covid ,:kidney_disease ,:skin_disease ,:thyreous_disease ,:hernia ,:low_back_pain ,:diabetes ,:gastitris ,:gynaecological ,
        :hemorrhoid ,:ulcer ,:varices ,:pneumonia ,:tuberculosis ,:colitis ,:depression ,:other_disease ,:hospitalization ,:reason_hospitalization ,:surgery ,:reason_surgery ,:transfusion ,
        :reason_transfusion ,:trauma_fracture ,:what_trauma_fracture ,:complication ,:what_complication ,:chronic_disease ,:what_chronic ,:current_treatment, :hypertension, :signature_patient )
        ");
         $sql->bindParam(':arthritis',$input['arthritis'],PDO::PARAM_STR);
         $sql->bindParam(':asthma',$input['asthma'],PDO::PARAM_STR);
         $sql->bindParam(':bronchitis',$input['bronchitis'],PDO::PARAM_STR);
         $sql->bindParam(':hepatitis',$input['hepatitis'],PDO::PARAM_STR);
         $sql->bindParam(':covid',$input['covid'],PDO::PARAM_STR);
         $sql->bindParam(':kidney_disease',$input['kidney_disease'],PDO::PARAM_STR);
         $sql->bindParam(':skin_disease',$input['skin_disease'],PDO::PARAM_STR);
         $sql->bindParam(':thyreous_disease',$input['thyreous_disease'],PDO::PARAM_STR);
         $sql->bindParam(':hernia',$input['hernia'],PDO::PARAM_STR);
         $sql->bindParam(':hypertension',$input['hypertension'],PDO::PARAM_STR);
         $sql->bindParam(':low_back_pain',$input['low_back_pain'],PDO::PARAM_STR);
         $sql->bindParam(':diabetes',$input['diabetes'],PDO::PARAM_STR);
         $sql->bindParam(':gastitris',$input['gastitris'],PDO::PARAM_STR);
         $sql->bindParam(':gynaecological',$input['gynaecological'],PDO::PARAM_STR);
         $sql->bindParam(':hemorrhoid',$input['hemorrhoid'],PDO::PARAM_STR);
         $sql->bindParam(':ulcer',$input['ulcer'],PDO::PARAM_STR);
         $sql->bindParam(':varices',$input['varices'],PDO::PARAM_STR);
         $sql->bindParam(':pneumonia',$input['pneumonia'],PDO::PARAM_STR);
         $sql->bindParam(':tuberculosis',$input['tuberculosis'],PDO::PARAM_STR);
         $sql->bindParam(':colitis',$input['colitis'],PDO::PARAM_STR);
         $sql->bindParam(':depression',$input['depression'],PDO::PARAM_STR);
         $sql->bindParam(':other_disease',$input['other_disease'],PDO::PARAM_STR);
         $sql->bindParam(':hospitalization',$input['hospitalization'],PDO::PARAM_STR);
         $sql->bindParam(':reason_hospitalization',$input['reason_hospitalization'],PDO::PARAM_STR);
         $sql->bindParam(':surgery',$input['surgery'],PDO::PARAM_STR);
         $sql->bindParam(':reason_surgery',$input['reason_surgery'],PDO::PARAM_STR);
         $sql->bindParam(':transfusion',$input['transfusion'],PDO::PARAM_STR);
         $sql->bindParam(':reason_transfusion',$input['reason_transfusion'],PDO::PARAM_STR);
         $sql->bindParam(':trauma_fracture',$input['trauma_fracture'],PDO::PARAM_STR);
         $sql->bindParam(':what_trauma_fracture',$input['what_trauma_fracture'],PDO::PARAM_STR);
         $sql->bindParam(':complication',$input['complication'],PDO::PARAM_STR);
         $sql->bindParam(':what_complication',$input['what_complication'],PDO::PARAM_STR);
         $sql->bindParam(':chronic_disease',$input['chronic_disease'],PDO::PARAM_STR);
         $sql->bindParam(':what_chronic',$input['what_chronic'],PDO::PARAM_STR);
         $sql->bindParam(':current_treatment',$input['current_treatment'],PDO::PARAM_STR);
         $sql->bindParam(':signature_patient',$input['signature_patient'],PDO::PARAM_STR);
         
        if ($sql->execute()) {
            $lastInsertedId = $connection->lastInsertId();
            return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
        }
    }
    
    function post_examPersonalLife($input) {
        $connection = $this->connect();
        $sql = $connection->prepare("
            INSERT INTO `medical_prIn_personal_file`(`name`, `address`, `place_birthday`, `date_birthday`, `schooling`, `college_career`, `sex`, `age`, `marital_status`, `tel_cel`, `extra_activity`, `number_children`) 
            VALUES  (:name, :address, :place_birthday, :date_birthday, :schooling, :college_career, :sex, :age, :marital_status, :tel_cel, :extra_activity, :number_children)
        ");
        $sql->bindParam(':name',$input['name'],PDO::PARAM_STR);
        $sql->bindParam(':address',$input['address'],PDO::PARAM_STR);
        $sql->bindParam(':place_birthday',$input['place_birthday'],PDO::PARAM_STR);
        $sql->bindParam(':date_birthday',$input['date_birthday'],PDO::PARAM_STR);
        $sql->bindParam(':schooling',$input['schooling'],PDO::PARAM_STR);
        $sql->bindParam(':college_career',$input['college_career'],PDO::PARAM_STR);
        $sql->bindParam(':sex',$input['sex'],PDO::PARAM_INT);
        $sql->bindParam(':age',$input['age'],PDO::PARAM_INT);
        $sql->bindParam(':marital_status',$input['marital_status'],PDO::PARAM_STR);
        $sql->bindParam(':tel_cel',$input['tel_cel'],PDO::PARAM_INT);
        $sql->bindParam(':extra_activity',$input['extra_activity'],PDO::PARAM_STR);
        $sql->bindParam(':number_children',$input['number_children'],PDO::PARAM_INT);
        
        if ($sql->execute()) {
            $lastInsertedId = $connection->lastInsertId();
            return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
        }
    }
    
    function post_examPhyExploration($input) {
        $connection = $this->connect();
        $sql = $connection->prepare("
        INSERT INTO `medical_prIn_phy_exploration`(`t_a`, `f_c`, `weight`, `height`, `p_abd`, `f_r`, `temp`, `i_m_c`, `general_dln`, `attitude`, `march`, `appearence`, `edo_animo`
        , `ear_dln`, `ear_d`, `ear_i`, `cae_d`, `cae_i`, `eardrum_d`, `eardrum_i`, `head_dln`, `hair`, `surface`, `shape`, `breast_pn`, `eye_dln`, `reflex`, `pupil`, `back_eye`, `pterigion_d`,
        `pterigion_i`, `neuro_dln`, `reflex_ot`, `romberg`, `heel_knee`, `mouth_dln`, `lip`, `breath`, `tongue`, `pharynx`, `amygdala`, `tooth`, `mucosa`, `thorax_dln`, `shape_thorax`, `diaphragm`,
        `rub_thorax`, `ventilation_thorax`, `rales`, `abdomen_dln`, `shape_abdomen`, `pain`, `mass`, `hernia_d`, `hernia_i`, `nose_dln`, `septum`, `mucosa_d`, `mucosa_i`, `ventilation_nose`, `precordial_area_dln`,
        `often`, `rhythm`, `tones`, `rub_precordial`, `puff_precordial`, `skin_dln`, `scar`, `texture`, `diaphoresis`, `other_injury`, `extremity_dln`, `articulate_ext_d`, `articulate_ext_i`, `muscular_ext_d`, `muscular_ext_i`, 
        `nervous_ext_d`, `nervous_ext_i`, `articulate_mi_d`, `articulate_mi_i`, `muscular_mi_d`, `mucular_mi_i`, `nervous_mi_d`, `nervous_mi_i`, `str_column`) 
        VALUES (:t_a, :f_c, :weight, :height, :p_abd, :f_r, :temp, :i_m_c, :general_dln, :attitude, :march, :appearence, :edo_animo,
        :ear_dln, :ear_d, :ear_i, :cae_d, :cae_i, :eardrum_d, :eardrum_i, :head_dln, :hair, :surface, :shape, :breast_pn, :eye_dln, :reflex,
        :pupil, :back_eye, :pterigion_d, :pterigion_i, :neuro_dln, :reflex_ot, :romberg, :heel_knee, :mouth_dln, :lip, :breath, :tongue, :pharynx, :amygdala,
        :tooth, :mucosa, :thorax_dln, :shape_thorax, :diaphragm, :rub_thorax, :ventilation_thorax, :rales, :abdomen_dln, :shape_abdomen, :pain, :mass, :hernia_d, :hernia_i,
        :nose_dln, :septum, :mucosa_d, :mucosa_i, :ventilation_nose, :precordial_area_dln, :often, :rhythm, :tones, :rub_precordial, :puff_precordial, :skin_dln, :scar, :texture,
        :diaphoresis, :other_injury, :extremity_dln, :articulate_ext_d, :articulate_ext_i, :muscular_ext_d, :muscular_ext_i, :nervous_ext_d, :nervous_ext_i, :articulate_mi_d, :articulate_mi_i, :muscular_mi_d, :mucular_mi_i, :nervous_mi_d,
        :nervous_mi_i, :str_column)
        ");
        $sql->bindParam(':t_a',$input['t_a'],PDO::PARAM_STR);
        $sql->bindParam(':f_c',$input['f_c'],PDO::PARAM_STR);
        $sql->bindParam(':weight',$input['weight'],PDO::PARAM_STR);
        $sql->bindParam(':height',$input['height'],PDO::PARAM_STR);
        $sql->bindParam(':p_abd',$input['p_abd'],PDO::PARAM_STR);
        $sql->bindParam(':f_r',$input['f_r'],PDO::PARAM_STR);
        $sql->bindParam(':temp',$input['temp'],PDO::PARAM_STR);
        $sql->bindParam(':i_m_c',$input['i_m_c'],PDO::PARAM_STR);
        $sql->bindParam(':general_dln',$input['general_dln'],PDO::PARAM_STR);
        $sql->bindParam(':attitude',$input['attitude'],PDO::PARAM_STR);
        $sql->bindParam(':march',$input['march'],PDO::PARAM_STR);
        $sql->bindParam(':appearence',$input['appearence'],PDO::PARAM_STR);
        $sql->bindParam(':edo_animo',$input['edo_animo'],PDO::PARAM_STR);
        $sql->bindParam(':ear_dln',$input['ear_dln'],PDO::PARAM_STR);
        $sql->bindParam(':ear_d',$input['ear_d'],PDO::PARAM_STR);
        $sql->bindParam(':ear_i',$input['ear_i'],PDO::PARAM_STR);
        $sql->bindParam(':cae_d',$input['cae_d'],PDO::PARAM_STR);
        $sql->bindParam(':cae_i',$input['cae_i'],PDO::PARAM_STR);
        $sql->bindParam(':eardrum_d',$input['eardrum_d'],PDO::PARAM_STR);
        $sql->bindParam(':eardrum_i',$input['eardrum_i'],PDO::PARAM_STR);
        $sql->bindParam(':head_dln',$input['head_dln'],PDO::PARAM_STR);
        $sql->bindParam(':hair',$input['hair'],PDO::PARAM_STR);
        $sql->bindParam(':surface',$input['surface'],PDO::PARAM_STR);
        $sql->bindParam(':shape',$input['shape'],PDO::PARAM_STR);
        $sql->bindParam(':breast_pn',$input['breast_pn'],PDO::PARAM_STR);
        $sql->bindParam(':eye_dln',$input['eye_dln'],PDO::PARAM_STR);
        $sql->bindParam(':reflex',$input['reflex'],PDO::PARAM_STR);
        $sql->bindParam(':pupil',$input['pupil'],PDO::PARAM_STR);
        $sql->bindParam(':back_eye',$input['back_eye'],PDO::PARAM_STR);
        $sql->bindParam(':pterigion_d',$input['pterigion_d'],PDO::PARAM_STR);
        $sql->bindParam(':pterigion_i',$input['pterigion_i'],PDO::PARAM_STR);
        $sql->bindParam(':neuro_dln',$input['neuro_dln'],PDO::PARAM_STR);
        $sql->bindParam(':reflex_ot',$input['reflex_ot'],PDO::PARAM_STR);
        $sql->bindParam(':romberg',$input['romberg'],PDO::PARAM_STR);
        $sql->bindParam(':heel_knee',$input['heel_knee'],PDO::PARAM_STR);
        $sql->bindParam(':mouth_dln',$input['mouth_dln'],PDO::PARAM_STR);
        $sql->bindParam(':lip',$input['lip'],PDO::PARAM_STR);
        $sql->bindParam(':breath',$input['breath'],PDO::PARAM_STR);
        $sql->bindParam(':tongue',$input['tongue'],PDO::PARAM_STR);
        $sql->bindParam(':pharynx',$input['pharynx'],PDO::PARAM_STR);
        $sql->bindParam(':amygdala',$input['amygdala'],PDO::PARAM_STR);
        $sql->bindParam(':tooth',$input['tooth'],PDO::PARAM_STR);
        $sql->bindParam(':mucosa',$input['mucosa'],PDO::PARAM_STR);
        $sql->bindParam(':thorax_dln',$input['thorax_dln'],PDO::PARAM_STR);
        $sql->bindParam(':shape_thorax',$input['shape_thorax'],PDO::PARAM_STR);
        $sql->bindParam(':diaphragm',$input['diaphragm'],PDO::PARAM_STR);
        $sql->bindParam(':rub_thorax',$input['rub_thorax'],PDO::PARAM_STR);
        $sql->bindParam(':ventilation_thorax',$input['ventilation_thorax'],PDO::PARAM_STR);
        $sql->bindParam(':rales',$input['rales'],PDO::PARAM_STR);
        $sql->bindParam(':abdomen_dln',$input['abdomen_dln'],PDO::PARAM_STR);
        $sql->bindParam(':shape_abdomen',$input['shape_abdomen'],PDO::PARAM_STR);
        $sql->bindParam(':pain',$input['pain'],PDO::PARAM_STR);
        $sql->bindParam(':mass',$input['mass'],PDO::PARAM_STR);
        $sql->bindParam(':hernia_d',$input['hernia_d'],PDO::PARAM_STR);
        $sql->bindParam(':hernia_i',$input['hernia_i'],PDO::PARAM_STR);
        $sql->bindParam(':nose_dln',$input['nose_dln'],PDO::PARAM_STR);
        $sql->bindParam(':septum',$input['septum'],PDO::PARAM_STR);
        $sql->bindParam(':mucosa_d',$input['mucosa_d'],PDO::PARAM_STR);
        $sql->bindParam(':mucosa_i',$input['mucosa_i'],PDO::PARAM_STR);
        $sql->bindParam(':ventilation_nose',$input['ventilation_nose'],PDO::PARAM_STR);
        $sql->bindParam(':precordial_area_dln',$input['precordial_area_dln'],PDO::PARAM_STR);
        $sql->bindParam(':often',$input['often'],PDO::PARAM_STR);
        $sql->bindParam(':rhythm',$input['rhythm'],PDO::PARAM_STR);
        $sql->bindParam(':tones',$input['tones'],PDO::PARAM_STR);
        $sql->bindParam(':rub_precordial',$input['rub_precordial'],PDO::PARAM_STR);
        $sql->bindParam(':puff_precordial',$input['puff_precordial'],PDO::PARAM_STR);
        $sql->bindParam(':skin_dln',$input['skin_dln'],PDO::PARAM_STR);
        $sql->bindParam(':scar',$input['scar'],PDO::PARAM_STR);
        $sql->bindParam(':texture',$input['texture'],PDO::PARAM_STR);
        $sql->bindParam(':diaphoresis',$input['diaphoresis'],PDO::PARAM_STR);
        $sql->bindParam(':other_injury',$input['other_injury'],PDO::PARAM_STR);
        $sql->bindParam(':extremity_dln',$input['extremity_dln'],PDO::PARAM_STR);
        $sql->bindParam(':articulate_ext_d',$input['articulate_ext_d'],PDO::PARAM_STR);
        $sql->bindParam(':articulate_ext_i',$input['articulate_ext_i'],PDO::PARAM_STR);
        $sql->bindParam(':muscular_ext_d',$input['muscular_ext_d'],PDO::PARAM_STR);
        $sql->bindParam(':muscular_ext_i',$input['muscular_ext_i'],PDO::PARAM_STR);
        $sql->bindParam(':nervous_ext_d',$input['nervous_ext_d'],PDO::PARAM_STR);
        $sql->bindParam(':nervous_ext_i',$input['nervous_ext_i'],PDO::PARAM_STR);
        $sql->bindParam(':articulate_mi_d',$input['articulate_mi_d'],PDO::PARAM_STR);
        $sql->bindParam(':articulate_mi_i',$input['articulate_mi_i'],PDO::PARAM_STR);
        $sql->bindParam(':muscular_mi_d',$input['muscular_mi_d'],PDO::PARAM_STR);
        $sql->bindParam(':mucular_mi_i',$input['mucular_mi_i'],PDO::PARAM_STR);
        $sql->bindParam(':nervous_mi_d',$input['nervous_mi_d'],PDO::PARAM_STR);
        $sql->bindParam(':nervous_mi_i',$input['nervous_mi_i'],PDO::PARAM_STR);
        $sql->bindParam(':str_column',$input['str_column'],PDO::PARAM_STR);
        
        if ($sql->execute()) {
            $lastInsertedId = $connection->lastInsertId();
            return json_encode(array("status" => "200", "container"=> [ [ "ultimoId" => $lastInsertedId] ], "info" => "Es el id de la insercion" ) );    
        } else {
            return json_encode(array("status" => "404", "container"=> [ [ "error" => $sql->errorInfo()[2] ] ], "info" => "Error de la consulta" ));
        }
    }
    
    function post_examPhyEyes($input) {
        $sql = $this->connect()->prepare("
        INSERT INTO `medical_prIn_phy_eyes`(`near_30cm`, `od_rosenbaun`, `oi_rosenbaun`, `od_jaeguer`, `oi_jaeguer`, `far_glasses`, `od_snellen`, `oi_snellen`, `od_campimetry`, `oi_campimetry`, 
        `color_campimetry`, `amsler_normal`, `fk_idExploration`) 
        VALUES (:near_30cm, :od_rosenbaun, :oi_rosenbaun, :od_jaeguer, :oi_jaeguer, :far_glasses, :od_snellen, :oi_snellen, :od_campimetry, :oi_campimetry, 
        :color_campimetry, :amsler_normal, :fk_idExploration)
        ");
        
        $sql->bindParam(':near_30cm',$input['near_30cm'],PDO::PARAM_STR);
        $sql->bindParam(':od_rosenbaun',$input['od_rosenbaun'],PDO::PARAM_STR);
        $sql->bindParam(':oi_rosenbaun',$input['oi_rosenbaun'],PDO::PARAM_STR);
        $sql->bindParam(':od_jaeguer',$input['od_jaeguer'],PDO::PARAM_STR);
        $sql->bindParam(':oi_jaeguer',$input['oi_jaeguer'],PDO::PARAM_STR);
        $sql->bindParam(':far_glasses',$input['far_glasses'],PDO::PARAM_STR);
        $sql->bindParam(':od_snellen',$input['od_snellen'],PDO::PARAM_STR);
        $sql->bindParam(':oi_snellen',$input['oi_snellen'],PDO::PARAM_STR);
        $sql->bindParam(':od_campimetry',$input['od_campimetry'],PDO::PARAM_STR);
        $sql->bindParam(':oi_campimetry',$input['oi_campimetry'],PDO::PARAM_STR);
        $sql->bindParam(':color_campimetry',$input['color_campimetry'],PDO::PARAM_STR);
        $sql->bindParam(':amsler_normal',$input['amsler_normal'],PDO::PARAM_STR);
        $sql->bindParam(':fk_idExploration',$input['fk_idExploration'],PDO::PARAM_INT);
        return $sql ->execute();
    }
    
    //ACTUALIZAR
    
    function patch_examMain($input) {
        $sql = $this->connect()->prepare("
            UPDATE `exams` SET `numEmployee`= :numEmployee WHERE `idExam`= :idExam;
        ");
        
        $sql->bindParam(':numEmployee', $input['numEmployee'] ,PDO::PARAM_INT);
        $sql->bindParam(':idExam', $input['idExam'] ,PDO::PARAM_INT);
        return $sql ->execute();
    }
    
    
    function patch_examDetail($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_det_exam` SET  `datetime_modification`= NOW(),
         `suitable`= :suitable, `not_suitable`= :not_suitable, `suitable_more`= :suitable_more, `condition_observation`= :condition_observation, 
        `applicant_signature`= :applicant_signature, `doctor_signature`= :doctor_signature  
        WHERE idDetExamInPr = ( SELECT fk_initial_pre_entry FROM exams WHERE idExam = :idExam );
        ");
        
        $sql->bindParam(':idExam', $input['idExam'] ,PDO::PARAM_INT);
        $sql->bindParam(':suitable', $input['suitable'] ,PDO::PARAM_STR);
        $sql->bindParam(':not_suitable', $input['not_suitable'] ,PDO::PARAM_STR);
        $sql->bindParam(':suitable_more', $input['suitable_more'] ,PDO::PARAM_STR);
        $sql->bindParam(':condition_observation', $input['condition_observation'] ,PDO::PARAM_STR);
        $sql->bindParam(':applicant_signature', $input['applicant_signature'] ,PDO::PARAM_STR);
        $sql->bindParam(':doctor_signature', $input['doctor_signature'] ,PDO::PARAM_STR);
        
        return $sql ->execute();
    }
    
    function patch_examAccident($input) {

       $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_acciddent_disease` SET `company`= :company, `date`= :date, `position`= :position, `causa`= :causa, 
        `disease_name`= :disease_name, `incapacity`= :incapacity, `number_d_incapacity`= :number_d_incapacity
        WHERE fk_idExam = ( SELECT fk_initial_pre_entry FROM `exams` WHERE idExam = :idExam ) and idFake = :idFake;
        ");
        
        $sql->bindParam(':idExam', $input['idExam'] ,PDO::PARAM_STR);
        $sql->bindParam(':company', $input['company'] ,PDO::PARAM_STR);
        $sql->bindParam(':date', $input['date'] ,PDO::PARAM_STR);
        $sql->bindParam(':position', $input['position'] ,PDO::PARAM_STR);
        $sql->bindParam(':causa', $input['causa'] ,PDO::PARAM_STR);
        $sql->bindParam(':disease_name', $input['disease_name'] ,PDO::PARAM_STR);
        $sql->bindParam(':incapacity', $input['incapacity'] ,PDO::PARAM_STR);
        $sql->bindParam(':number_d_incapacity', $input['number_d_incapacity'] ,PDO::PARAM_STR);
        //$sql->bindParam(':fk_idExam', $input['fk_idExam'] ,PDO::PARAM_STR);
        $sql->bindParam(':idFake', $input['idFake'] ,PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function patch_examApparatusSys($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_apparatus_sys` SET `sense`= :sense, `digestive`= :digestive, `respiratory`= :respiratory, 
        `circulatory`= :circulatory, `genitourinary`= :genitourinary, `muscle_skeletal`= :muscle_skeletal, `nervous`= :nervous 
        WHERE idAparattusSystem= (SELECT fk_apparatusSystem FROM `medical_prIn_det_exam` 
        INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr WHERE idExam = :idExam );
        ");
        
        $sql->bindParam(':idExam', $input['idExam'] ,PDO::PARAM_STR);
        $sql->bindParam(':sense', $input['sense'] ,PDO::PARAM_STR);
        $sql->bindParam(':digestive', $input['digestive'] ,PDO::PARAM_STR);
        $sql->bindParam(':respiratory', $input['respiratory'] ,PDO::PARAM_STR);
        $sql->bindParam(':circulatory', $input['circulatory'] ,PDO::PARAM_STR);
        $sql->bindParam(':genitourinary', $input['genitourinary'] ,PDO::PARAM_STR);
        $sql->bindParam(':muscle_skeletal', $input['muscle_skeletal'] ,PDO::PARAM_STR);
        $sql->bindParam(':nervous', $input['nervous'] ,PDO::PARAM_STR);
        return $sql->execute();
    }
    
    function patch_examGynecologistBack($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_gynecologist_back` SET `age_fmenstruation`= :age_fmenstruation,`age_stSex_life`= :age_stSex_life, `amount_pregnancy` = :amount_pregnancy,`amount_childbirth`= :amount_childbirth,
        `cesarean`= :cesarean,`abort`= :abort,`last_rule_date`= :last_rule_date,`rhythm`= :rhythm,`fk_contraceptive_method`= :fk_contraceptive_method,`date_last_pap_smear`= :date_last_pap_smear,
        `result_pap_smear`= :result_pap_smear,`mammography_date`= :mammography_date,`result_mammography`= :result_mammography,`lactation`= :lactation 
        WHERE fk_idHeredityPers= (SELECT fk_heredityPers FROM medical_prIn_det_exam 
        INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr WHERE idExam = :idExam);
        ");
        
        $sql->bindParam(':idExam', $input['idExam'] ,PDO::PARAM_STR);
        $sql->bindParam(':age_fmenstruation', $input['age_fmenstruation'] ,PDO::PARAM_STR);
        $sql->bindParam(':age_stSex_life', $input['age_stSex_life'] ,PDO::PARAM_STR);
        $sql->bindParam(':amount_childbirth', $input['amount_childbirth'] ,PDO::PARAM_STR);
        $sql->bindParam(':amount_pregnancy', $input['amount_pregnancy'] ,PDO::PARAM_STR);
        $sql->bindParam(':cesarean', $input['cesarean'] ,PDO::PARAM_STR);
        $sql->bindParam(':abort', $input['abort'] ,PDO::PARAM_STR);
        $sql->bindParam(':last_rule_date', $input['last_rule_date'] ,PDO::PARAM_STR);
        $sql->bindParam(':rhythm', $input['rhythm'] ,PDO::PARAM_STR);
        $sql->bindParam(':fk_contraceptive_method', $input['fk_contraceptive_method'] ,PDO::PARAM_STR);
        $sql->bindParam(':date_last_pap_smear', $input['date_last_pap_smear'] ,PDO::PARAM_STR);
        $sql->bindParam(':result_pap_smear', $input['result_pap_smear'] ,PDO::PARAM_STR);
        $sql->bindParam(':mammography_date', $input['mammography_date'] ,PDO::PARAM_STR);
        $sql->bindParam(':result_mammography', $input['result_mammography'] ,PDO::PARAM_STR);
        $sql->bindParam(':lactation', $input['lactation'] ,PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function patch_examHeredityFam($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_heredity_fam` SET `good_health`= :good_health, `bad_health`= :bad_health, 
        `deceased`= :deceased, `allergy`= :allergy, `diabetes`= :diabetes, `high_persion`= :high_persion, `cholesterol`= :cholesterol, 
        `heart_disease`= :heart_disease, `cancer`= :cancer, `anemia`= :anemia
        WHERE fk_idExam = (SELECT idDetExamInPr FROM medical_prIn_det_exam 
        INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr WHERE idExam = :idExam ) and fk_category_hef = :fk_category_hef;
        ");
        
        $sql->bindParam(':good_health', $input[0] ,PDO::PARAM_INT);
        $sql->bindParam(':bad_health', $input[1] ,PDO::PARAM_INT);
        $sql->bindParam(':deceased', $input[2] ,PDO::PARAM_INT);
        $sql->bindParam(':allergy', $input[3] ,PDO::PARAM_INT);
        $sql->bindParam(':diabetes', $input[4] ,PDO::PARAM_INT);
        $sql->bindParam(':high_persion', $input[5] ,PDO::PARAM_INT);
        $sql->bindParam(':cholesterol', $input[6] ,PDO::PARAM_INT);
        $sql->bindParam(':heart_disease', $input[7] ,PDO::PARAM_INT);
        $sql->bindParam(':cancer', $input[8] ,PDO::PARAM_INT);
        $sql->bindParam(':anemia', $input[9] ,PDO::PARAM_INT);
        $sql->bindParam(':fk_category_hef', $input[10] ,PDO::PARAM_INT);
        $sql->bindParam(':idExam', $input[12] ,PDO::PARAM_INT);
        
        return $sql ->execute();
    }
    
    function patch_examHeredityPers($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_heredity_pers` SET  `fk_dominant_hand`= :fk_dominant_hand, `smoking`= :smoking, `age_smoking`= :age_smoking, 
        `amount_cigarettes`= :amount_cigarettes, `alcohol`= :alcohol, `age_alcohol`= :age_alcohol, `often_alcohol`= :often_alcohol, `taxonomists`= :taxonomists, 
        `age_taxonomists`= :age_taxonomists, `often_taxonomists`= :often_taxonomists, `allergy_medicament`= :allergy_medicament, `what_medicament`= :what_medicament, 
        `allergy_food`= :allergy_food, `what_food`= :what_food, `covid_vaccine`= :covid_vaccine, `tetanus_vaccine`= :tetanus_vaccine, `hepatitis_vaccine`= :hepatitis_vaccine, 
        `pneumococcal_vaccine`= :pneumococcal_vaccine, `other_vaccine`= :other_vaccine, `practice_exercise`= :practice_exercise, `what_exercise`= :what_exercise, 
        `often_exercise`= :often_exercise WHERE idHeredityPers= (SELECT fk_heredityPers FROM medical_prIn_det_exam INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr WHERE idExam = :idExam );
        ");
        $sql->bindParam(':idExam', $input['idExam'] ,PDO::PARAM_STR);
        $sql->bindParam(':fk_dominant_hand', $input['fk_dominant_hand'] ,PDO::PARAM_STR);
        $sql->bindParam(':smoking', $input['smoking'] ,PDO::PARAM_STR);
        $sql->bindParam(':age_smoking', $input['age_smoking'] ,PDO::PARAM_STR);
        $sql->bindParam(':amount_cigarettes', $input['amount_cigarettes'] ,PDO::PARAM_STR);
        $sql->bindParam(':alcohol', $input['alcohol'] ,PDO::PARAM_STR);
        $sql->bindParam(':age_alcohol', $input['age_alcohol'] ,PDO::PARAM_STR);
        $sql->bindParam(':often_alcohol', $input['often_alcohol'] ,PDO::PARAM_STR);
        $sql->bindParam(':taxonomists', $input['taxonomists'] ,PDO::PARAM_STR);
        $sql->bindParam(':age_taxonomists', $input['age_taxonomists'] ,PDO::PARAM_STR);
        $sql->bindParam(':often_taxonomists', $input['often_taxonomists'] ,PDO::PARAM_STR);
        $sql->bindParam(':allergy_medicament', $input['allergy_medicament'] ,PDO::PARAM_STR);
        $sql->bindParam(':what_medicament', $input['what_medicament'] ,PDO::PARAM_STR);
        $sql->bindParam(':allergy_food', $input['allergy_food'] ,PDO::PARAM_STR);
        $sql->bindParam(':what_food', $input['what_food'] ,PDO::PARAM_STR);
        $sql->bindParam(':covid_vaccine', $input['covid_vaccine'] ,PDO::PARAM_STR);
        $sql->bindParam(':tetanus_vaccine', $input['tetanus_vaccine'] ,PDO::PARAM_STR);
        $sql->bindParam(':hepatitis_vaccine', $input['hepatitis_vaccine'] ,PDO::PARAM_STR);
        $sql->bindParam(':pneumococcal_vaccine', $input['pneumococcal_vaccine'] ,PDO::PARAM_STR);
        $sql->bindParam(':other_vaccine', $input['other_vaccine'] ,PDO::PARAM_STR);
        $sql->bindParam(':practice_exercise', $input['practice_exercise'] ,PDO::PARAM_STR);
        $sql->bindParam(':what_exercise', $input['what_exercise'] ,PDO::PARAM_STR);
        $sql->bindParam(':often_exercise', $input['often_exercise'] ,PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function patch_examHistory($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_history` SET `company`= :company,`position`= :position,`time`= :time, `when_left` = :when_left, `job_rotation` = :job_rotation, 
        `solvent_chemical` = :solvent_chemical, `fume` = :fume, `vapor` = :vapor, `dust` = :dust, `noisy` = :noisy, 
        `material_load` = :material_load WHERE fk_idExam = (SELECT idDetExamInPr FROM medical_prIn_det_exam 
            INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr WHERE idExam = :idExam ) and idFake = :idFake;
        ");
        $sql->bindParam(':idExam', $input['idExam'] ,PDO::PARAM_STR);
        $sql->bindParam(':company', $input['company'] ,PDO::PARAM_STR);
        $sql->bindParam(':position', $input['position'] ,PDO::PARAM_STR);
        $sql->bindParam(':when_left', $input['when_left'] ,PDO::PARAM_STR);
        $sql->bindParam(':job_rotation', $input['job_rotation'] ,PDO::PARAM_STR);
        $sql->bindParam(':solvent_chemical', $input['solvent_chemical'] ,PDO::PARAM_STR);
        $sql->bindParam(':fume', $input['fume'] ,PDO::PARAM_STR);
        $sql->bindParam(':vapor', $input['vapor'] ,PDO::PARAM_STR);
        $sql->bindParam(':dust', $input['dust'] ,PDO::PARAM_STR);
        $sql->bindParam(':noisy', $input['noisy'] ,PDO::PARAM_STR);
        $sql->bindParam(':material_load', $input['material_load'] ,PDO::PARAM_STR);
        $sql->bindParam(':idFake', $input['idFake'] ,PDO::PARAM_STR);
        $sql->bindParam(':time', $input['time'] ,PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function patch_examImagingStudy($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_imaging_study` SET `thorax_radiograph`= :thorax_radiograph,`rx_lumbar_spine`= :rx_lumbar_spine,
        `spirometry`= :spirometry,`audiometry`= :audiometry,`covid_test`= :covid_test,`pregnancy`= :pregnancy,`antidoping`= :antidoping 
        WHERE idImagingStudy = (SELECT fk_imagingStudy FROM medical_prIn_det_exam 
            INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr WHERE idExam = :idExam );
        ");
        $sql->bindParam(':idExam', $input['idExam'] ,PDO::PARAM_STR);
        $sql->bindParam(':thorax_radiograph', $input['thorax_radiograph'] ,PDO::PARAM_STR);
        $sql->bindParam(':rx_lumbar_spine', $input['rx_lumbar_spine'] ,PDO::PARAM_STR);
        $sql->bindParam(':spirometry', $input['spirometry'] ,PDO::PARAM_STR);
        $sql->bindParam(':audiometry', $input['audiometry'] ,PDO::PARAM_STR);
        $sql->bindParam(':covid_test', $input['covid_test'] ,PDO::PARAM_STR);
        $sql->bindParam(':pregnancy', $input['pregnancy'] ,PDO::PARAM_STR);
        $sql->bindParam(':antidoping', $input['antidoping'] ,PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function patch_examInitPre($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_init_or_pre` SET `departament`= :departament,`place`= :place,`type`= :type WHERE idInitOrPre= (SELECT fk_InitOrPre FROM medical_prIn_det_exam 
            INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr WHERE idExam = :idExam );
        ");
         $sql->bindParam(':idExam',$input['idExam'],PDO::PARAM_STR);
         $sql->bindParam(':departament',$input['departament'],PDO::PARAM_STR);
         $sql->bindParam(':place',$input['place'],PDO::PARAM_STR);
         $sql->bindParam(':type',$input['type'],PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function patch_examLaboratoryTest($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_laboratory_test` SET `result`= :result,`drug`= :drug WHERE idLaboratoryTest= (SELECT fk_laboratoryTest FROM medical_prIn_det_exam 
            INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr WHERE idExam = :idExam );
        ");
        
        $sql->bindParam(':idExam',$input['idExam'],PDO::PARAM_STR);
        $sql->bindParam(':result',$input['result'],PDO::PARAM_STR);
        $sql->bindParam(':drug',$input['drug'],PDO::PARAM_STR);
        
        return $sql ->execute();
    }
    
    function patch_examPataPersBack($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_pata_pers_back` SET `arthritis`= :arthritis ,`asthma`= :asthma ,`bronchitis`= :bronchitis ,
        `hepatitis`= :hepatitis ,`kidney_disease`= :kidney_disease ,`skin_disease`= :skin_disease, `covid` = :covid ,`thyreous_disease`= :thyreous_disease ,`hernia`= :hernia ,`low_back_pain`= :low_back_pain ,
        `diabetes`= :diabetes ,`gastitris`= :gastitris ,`gynaecological`= :gynaecological ,`hemorrhoid`= :hemorrhoid ,`ulcer`= :ulcer ,`varices`= :varices ,
        `pneumonia`= :pneumonia ,`tuberculosis`= :tuberculosis ,`colitis`= :colitis ,`depression`= :depression ,`other_disease`= :other_disease ,`hospitalization`= :hospitalization ,
        `reason_hospitalization`= :reason_hospitalization ,`surgery`= :surgery ,`reason_surgery`= :reason_surgery ,`transfusion`= :transfusion ,`reason_transfusion`= :reason_transfusion ,
        `trauma_fracture`= :trauma_fracture ,`what_trauma_fracture`= :what_trauma_fracture ,`complication`= :complication ,`what_complication`= :what_complication ,`chronic_disease`= :chronic_disease ,
        `what_chronic`= :what_chronic ,`current_treatment`= :current_treatment, hypertension = :hypertension, signature_patient = :signature_patient  WHERE idPatalogicalPersBack= (SELECT fk_patalogicalPersBack FROM medical_prIn_det_exam 
            INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr WHERE idExam = :idExam ) ;
        ");
            
         $sql->bindParam(':idExam',$input['idExam'],PDO::PARAM_STR);
         $sql->bindParam(':arthritis',$input['arthritis'],PDO::PARAM_STR);
         $sql->bindParam(':asthma',$input['asthma'],PDO::PARAM_STR);
         $sql->bindParam(':bronchitis',$input['bronchitis'],PDO::PARAM_STR);
         $sql->bindParam(':hepatitis',$input['hepatitis'],PDO::PARAM_STR);
         $sql->bindParam(':kidney_disease',$input['kidney_disease'],PDO::PARAM_STR);
         $sql->bindParam(':skin_disease',$input['skin_disease'],PDO::PARAM_STR);
         $sql->bindParam(':thyreous_disease',$input['thyreous_disease'],PDO::PARAM_STR);
         $sql->bindParam(':hernia',$input['hernia'],PDO::PARAM_STR);
         $sql->bindParam(':low_back_pain',$input['low_back_pain'],PDO::PARAM_STR);
         $sql->bindParam(':diabetes',$input['diabetes'],PDO::PARAM_STR);
         $sql->bindParam(':gastitris',$input['gastitris'],PDO::PARAM_STR);
         $sql->bindParam(':gynaecological',$input['gynaecological'],PDO::PARAM_STR);
         $sql->bindParam(':covid',$input['covid'],PDO::PARAM_STR);
         $sql->bindParam(':hemorrhoid',$input['hemorrhoid'],PDO::PARAM_STR);
         $sql->bindParam(':ulcer',$input['ulcer'],PDO::PARAM_STR);
         $sql->bindParam(':varices',$input['varices'],PDO::PARAM_STR);
         $sql->bindParam(':hypertension',$input['hypertension'],PDO::PARAM_STR);
         $sql->bindParam(':pneumonia',$input['pneumonia'],PDO::PARAM_STR);
         $sql->bindParam(':tuberculosis',$input['tuberculosis'],PDO::PARAM_STR);
         $sql->bindParam(':colitis',$input['colitis'],PDO::PARAM_STR);
         $sql->bindParam(':depression',$input['depression'],PDO::PARAM_STR);
         $sql->bindParam(':other_disease',$input['other_disease'],PDO::PARAM_STR);
         $sql->bindParam(':hospitalization',$input['hospitalization'],PDO::PARAM_STR);
         $sql->bindParam(':reason_hospitalization',$input['reason_hospitalization'],PDO::PARAM_STR);
         $sql->bindParam(':surgery',$input['surgery'],PDO::PARAM_STR);
         $sql->bindParam(':reason_surgery',$input['reason_surgery'],PDO::PARAM_STR);
         $sql->bindParam(':transfusion',$input['transfusion'],PDO::PARAM_STR);
         $sql->bindParam(':reason_transfusion',$input['reason_transfusion'],PDO::PARAM_STR);
         $sql->bindParam(':trauma_fracture',$input['trauma_fracture'],PDO::PARAM_STR);
         $sql->bindParam(':what_trauma_fracture',$input['what_trauma_fracture'],PDO::PARAM_STR);
         $sql->bindParam(':complication',$input['complication'],PDO::PARAM_STR);
         $sql->bindParam(':what_complication',$input['what_complication'],PDO::PARAM_STR);
         $sql->bindParam(':chronic_disease',$input['chronic_disease'],PDO::PARAM_STR);
         $sql->bindParam(':what_chronic',$input['what_chronic'],PDO::PARAM_STR);
         $sql->bindParam(':current_treatment',$input['current_treatment'],PDO::PARAM_STR);
         $sql->bindParam(':signature_patient',$input['signature_patient'],PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function patch_examPersonalLife($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_personal_file` SET `name`= :name ,`address`= :address ,`place_birthday` = :place_birthday,
        `date_birthday` = :date_birthday, `schooling`= :schooling ,`college_career`= :college_career ,
        `sex`= :sex ,`age`= :age ,`marital_status`= :marital_status ,`tel_cel`= :tel_cel ,
        `extra_activity`= :extra_activity ,`number_children`= :number_children  WHERE idPersonal= (SELECT fk_personalLife FROM medical_prIn_det_exam 
            INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr WHERE idExam = :idExam );
        ");
      
        $sql->bindParam(':idExam',$input['idExam'],PDO::PARAM_STR);
        $sql->bindParam(':name',$input['name'],PDO::PARAM_STR);
        $sql->bindParam(':address',$input['address'],PDO::PARAM_STR);
        $sql->bindParam(':place_birthday',$input['place_birthday'],PDO::PARAM_STR);
        $sql->bindParam(':date_birthday',$input['date_birthday'],PDO::PARAM_STR);
        $sql->bindParam(':schooling',$input['schooling'],PDO::PARAM_STR);
        $sql->bindParam(':college_career',$input['college_career'],PDO::PARAM_STR);
        $sql->bindParam(':sex',$input['sex'],PDO::PARAM_STR);
        $sql->bindParam(':age',$input['age'],PDO::PARAM_STR);
        $sql->bindParam(':marital_status',$input['marital_status'],PDO::PARAM_STR);
        $sql->bindParam(':tel_cel',$input['tel_cel'],PDO::PARAM_STR);
        $sql->bindParam(':extra_activity',$input['extra_activity'],PDO::PARAM_STR);
        $sql->bindParam(':number_children',$input['number_children'],PDO::PARAM_STR);

        return $sql ->execute();
    }
    
    function patch_examPhyExploration($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_phy_exploration` SET `t_a`= :t_a, `f_c`= :f_c, `weight`= :weight, `height`= :height, `p_abd`= :p_abd, 
        `f_r`= :f_r, `temp`= :temp, `i_m_c`= :i_m_c, `general_dln`= :general_dln, `attitude`= :attitude, `march`= :march, `appearence`= :appearence, 
        `edo_animo`= :edo_animo, `ear_dln`= :ear_dln, `ear_d`= :ear_d, `ear_i`= :ear_i, `cae_d`= :cae_d, `cae_i`= :cae_i, `eardrum_d`= :eardrum_d, 
        `eardrum_i`= :eardrum_i, `head_dln`= :head_dln, `hair`= :hair, `surface`= :surface, `shape`= :shape, `breast_pn`= :breast_pn, `eye_dln`= :eye_dln, 
        `reflex`= :reflex, `pupil`= :pupil, `back_eye`= :back_eye, `pterigion_d`= :pterigion_d, `pterigion_i`= :pterigion_i, `neuro_dln`= :neuro_dln, `reflex_ot`= :reflex_ot, 
        `romberg`= :romberg, `heel_knee`= :heel_knee, `mouth_dln`= :mouth_dln, `lip`= :lip, `breath`= :breath, `tongue`= :tongue, `pharynx`= :pharynx, 
        `amygdala`= :amygdala, `tooth`= :tooth, `mucosa`= :mucosa, `thorax_dln`= :thorax_dln, `shape_thorax`= :shape_thorax, `diaphragm`= :diaphragm, `rub_thorax`= :rub_thorax, 
        `ventilation_thorax`= :ventilation_thorax, `rales`= :rales, `abdomen_dln`= :abdomen_dln, `shape_abdomen`= :shape_abdomen, `pain`= :pain, `mass`= :mass, `hernia_d`= :hernia_d, 
        `hernia_i`= :hernia_i, `nose_dln`= :nose_dln, `septum`= :septum, `mucosa_d`= :mucosa_d, `mucosa_i`= :mucosa_i, `ventilation_nose`= :ventilation_nose, 
        `precordial_area_dln`= :precordial_area_dln, `often`= :often, `rhythm`= :rhythm, `tones`= :tones, `rub_precordial`= :rub_precordial, `puff_precordial`= :puff_precordial, 
        `skin_dln`= :skin_dln, `scar`= :scar ,`texture`= :texture, `diaphoresis`= :diaphoresis, `other_injury`= :other_injury, `extremity_dln`= :extremity_dln ,
        `articulate_ext_d`= :articulate_ext_d, `articulate_ext_i`= :articulate_ext_i, `muscular_ext_d`= :muscular_ext_d, `muscular_ext_i`= :muscular_ext_i, `nervous_ext_d`= :nervous_ext_d, 
        `nervous_ext_i`= :nervous_ext_i, `articulate_mi_d`= :articulate_mi_d, `articulate_mi_i`= :articulate_mi_i, `muscular_mi_d`= :muscular_mi_d, `mucular_mi_i`= :mucular_mi_i ,
        `nervous_mi_d`= :nervous_mi_d, `nervous_mi_i`= :nervous_mi_i, `str_column`= :str_column  WHERE idExploration=  (SELECT fk_physicalExploration FROM medical_prIn_det_exam 
            INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr WHERE idExam = :idExam )
        ");
        
        $sql->bindParam(':idExam',$input['idExam'],PDO::PARAM_STR);
        $sql->bindParam(':t_a',$input['t_a'],PDO::PARAM_STR);
        $sql->bindParam(':f_c',$input['f_c'],PDO::PARAM_STR);
        $sql->bindParam(':weight',$input['weight'],PDO::PARAM_STR);
        $sql->bindParam(':height',$input['height'],PDO::PARAM_STR);
        $sql->bindParam(':p_abd',$input['p_abd'],PDO::PARAM_STR);
        $sql->bindParam(':f_r',$input['f_r'],PDO::PARAM_STR);
        $sql->bindParam(':temp',$input['temp'],PDO::PARAM_STR);
        $sql->bindParam(':i_m_c',$input['i_m_c'],PDO::PARAM_STR);
        $sql->bindParam(':general_dln',$input['general_dln'],PDO::PARAM_STR);
        $sql->bindParam(':attitude',$input['attitude'],PDO::PARAM_STR);
        $sql->bindParam(':march',$input['march'],PDO::PARAM_STR);
        $sql->bindParam(':appearence',$input['appearence'],PDO::PARAM_STR);
        $sql->bindParam(':edo_animo',$input['edo_animo'],PDO::PARAM_STR);
        $sql->bindParam(':ear_dln',$input['ear_dln'],PDO::PARAM_STR);
        $sql->bindParam(':ear_d',$input['ear_d'],PDO::PARAM_STR);
        $sql->bindParam(':ear_i',$input['ear_i'],PDO::PARAM_STR);
        $sql->bindParam(':cae_d',$input['cae_d'],PDO::PARAM_STR);
        $sql->bindParam(':cae_i',$input['cae_i'],PDO::PARAM_STR);
        $sql->bindParam(':eardrum_d',$input['eardrum_d'],PDO::PARAM_STR);
        $sql->bindParam(':eardrum_i',$input['eardrum_i'],PDO::PARAM_STR);
        $sql->bindParam(':head_dln',$input['head_dln'],PDO::PARAM_STR);
        $sql->bindParam(':hair',$input['hair'],PDO::PARAM_STR);
        $sql->bindParam(':surface',$input['surface'],PDO::PARAM_STR);
        $sql->bindParam(':shape',$input['shape'],PDO::PARAM_STR);
        $sql->bindParam(':breast_pn',$input['breast_pn'],PDO::PARAM_STR);
        $sql->bindParam(':eye_dln',$input['eye_dln'],PDO::PARAM_STR);
        $sql->bindParam(':reflex',$input['reflex'],PDO::PARAM_STR);
        $sql->bindParam(':pupil',$input['pupil'],PDO::PARAM_STR);
        $sql->bindParam(':back_eye',$input['back_eye'],PDO::PARAM_STR);
        $sql->bindParam(':pterigion_d',$input['pterigion_d'],PDO::PARAM_STR);
        $sql->bindParam(':pterigion_i',$input['pterigion_i'],PDO::PARAM_STR);
        $sql->bindParam(':neuro_dln',$input['neuro_dln'],PDO::PARAM_STR);
        $sql->bindParam(':reflex_ot',$input['reflex_ot'],PDO::PARAM_STR);
        $sql->bindParam(':romberg',$input['romberg'],PDO::PARAM_STR);
        $sql->bindParam(':heel_knee',$input['heel_knee'],PDO::PARAM_STR);
        $sql->bindParam(':mouth_dln',$input['mouth_dln'],PDO::PARAM_STR);
        $sql->bindParam(':lip',$input['lip'],PDO::PARAM_STR);
        $sql->bindParam(':breath',$input['breath'],PDO::PARAM_STR);
        $sql->bindParam(':tongue',$input['tongue'],PDO::PARAM_STR);
        $sql->bindParam(':pharynx',$input['pharynx'],PDO::PARAM_STR);
        $sql->bindParam(':amygdala',$input['amygdala'],PDO::PARAM_STR);
        $sql->bindParam(':tooth',$input['tooth'],PDO::PARAM_STR);
        $sql->bindParam(':mucosa',$input['mucosa'],PDO::PARAM_STR);
        $sql->bindParam(':thorax_dln',$input['thorax_dln'],PDO::PARAM_STR);
        $sql->bindParam(':shape_thorax',$input['shape_thorax'],PDO::PARAM_STR);
        $sql->bindParam(':diaphragm',$input['diaphragm'],PDO::PARAM_STR);
        $sql->bindParam(':rub_thorax',$input['rub_thorax'],PDO::PARAM_STR);
        $sql->bindParam(':ventilation_thorax',$input['ventilation_thorax'],PDO::PARAM_STR);
        $sql->bindParam(':rales',$input['rales'],PDO::PARAM_STR);
        $sql->bindParam(':abdomen_dln',$input['abdomen_dln'],PDO::PARAM_STR);
        $sql->bindParam(':shape_abdomen',$input['shape_abdomen'],PDO::PARAM_STR);
        $sql->bindParam(':pain',$input['pain'],PDO::PARAM_STR);
        $sql->bindParam(':mass',$input['mass'],PDO::PARAM_STR);
        $sql->bindParam(':hernia_d',$input['hernia_d'],PDO::PARAM_STR);
        $sql->bindParam(':hernia_i',$input['hernia_i'],PDO::PARAM_STR);
        $sql->bindParam(':nose_dln',$input['nose_dln'],PDO::PARAM_STR);
        $sql->bindParam(':septum',$input['septum'],PDO::PARAM_STR);
        $sql->bindParam(':mucosa_d',$input['mucosa_d'],PDO::PARAM_STR);
        $sql->bindParam(':mucosa_i',$input['mucosa_i'],PDO::PARAM_STR);
        $sql->bindParam(':ventilation_nose',$input['ventilation_nose'],PDO::PARAM_STR);
        $sql->bindParam(':precordial_area_dln',$input['precordial_area_dln'],PDO::PARAM_STR);
        $sql->bindParam(':often',$input['often'],PDO::PARAM_STR);
        $sql->bindParam(':rhythm',$input['rhythm'],PDO::PARAM_STR);
        $sql->bindParam(':tones',$input['tones'],PDO::PARAM_STR);
        $sql->bindParam(':rub_precordial',$input['rub_precordial'],PDO::PARAM_STR);
        $sql->bindParam(':puff_precordial',$input['puff_precordial'],PDO::PARAM_STR);
        $sql->bindParam(':skin_dln',$input['skin_dln'],PDO::PARAM_STR);
        $sql->bindParam(':scar',$input['scar'],PDO::PARAM_STR);
        $sql->bindParam(':texture',$input['texture'],PDO::PARAM_STR);
        $sql->bindParam(':diaphoresis',$input['diaphoresis'],PDO::PARAM_STR);
        $sql->bindParam(':other_injury',$input['other_injury'],PDO::PARAM_STR);
        $sql->bindParam(':extremity_dln',$input['extremity_dln'],PDO::PARAM_STR);
        $sql->bindParam(':articulate_ext_d',$input['articulate_ext_d'],PDO::PARAM_STR);
        $sql->bindParam(':articulate_ext_i',$input['articulate_ext_i'],PDO::PARAM_STR);
        $sql->bindParam(':muscular_ext_d',$input['muscular_ext_d'],PDO::PARAM_STR);
        $sql->bindParam(':muscular_ext_i',$input['muscular_ext_i'],PDO::PARAM_STR);
        $sql->bindParam(':nervous_ext_d',$input['nervous_ext_d'],PDO::PARAM_STR);
        $sql->bindParam(':nervous_ext_i',$input['nervous_ext_i'],PDO::PARAM_STR);
        $sql->bindParam(':articulate_mi_d',$input['articulate_mi_d'],PDO::PARAM_STR);
        $sql->bindParam(':articulate_mi_i',$input['articulate_mi_i'],PDO::PARAM_STR);
        $sql->bindParam(':muscular_mi_d',$input['muscular_mi_d'],PDO::PARAM_STR);
        $sql->bindParam(':mucular_mi_i',$input['mucular_mi_i'],PDO::PARAM_STR);
        $sql->bindParam(':nervous_mi_d',$input['nervous_mi_d'],PDO::PARAM_STR);
        $sql->bindParam(':nervous_mi_i',$input['nervous_mi_i'],PDO::PARAM_STR);
        $sql->bindParam(':str_column',$input['str_column'],PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function patch_examPhyEyes($input) {
        $sql = $this->connect()->prepare("
        UPDATE `medical_prIn_phy_eyes` SET `near_30cm`= :near_30cm ,`od_rosenbaun`= :od_rosenbaun ,`oi_rosenbaun`= :oi_rosenbaun ,`od_jaeguer`= :od_jaeguer ,
        `oi_jaeguer`= :oi_jaeguer ,`far_glasses`= :far_glasses ,`od_snellen`= :od_snellen ,`oi_snellen`= :oi_snellen ,`od_campimetry`= :od_campimetry ,`oi_campimetry`= :oi_campimetry ,
        `color_campimetry`= :color_campimetry ,`amsler_normal`= :amsler_normal  WHERE fk_idExploration = (SELECT fk_physicalExploration FROM medical_prIn_det_exam INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr WHERE idExam = :idExam );
        ");
        $sql->bindParam(':idExam',$input['idExam'],PDO::PARAM_STR);
        $sql->bindParam(':near_30cm',$input['near_30cm'],PDO::PARAM_STR);
        $sql->bindParam(':od_rosenbaun',$input['od_rosenbaun'],PDO::PARAM_STR);
        $sql->bindParam(':oi_rosenbaun',$input['oi_rosenbaun'],PDO::PARAM_STR);
        $sql->bindParam(':od_jaeguer',$input['od_jaeguer'],PDO::PARAM_STR);
        $sql->bindParam(':oi_jaeguer',$input['oi_jaeguer'],PDO::PARAM_STR);
        $sql->bindParam(':far_glasses',$input['far_glasses'],PDO::PARAM_STR);
        $sql->bindParam(':od_snellen',$input['od_snellen'],PDO::PARAM_STR);
        $sql->bindParam(':oi_snellen',$input['oi_snellen'],PDO::PARAM_STR);
        $sql->bindParam(':od_campimetry',$input['od_campimetry'],PDO::PARAM_STR);
        $sql->bindParam(':oi_campimetry',$input['oi_campimetry'],PDO::PARAM_STR);
        $sql->bindParam(':color_campimetry',$input['color_campimetry'],PDO::PARAM_STR);
        $sql->bindParam(':amsler_normal',$input['amsler_normal'],PDO::PARAM_STR);
        return $sql ->execute();
    }
    
    function get_allExamListSearch($input){
        $word = '%'.$input[0].'%';
        $sql = $this->connect()->prepare('
        SELECT `idExam`,numEmployee, name, datetime_modification, examName 
        FROM medical_prIn_det_exam as mpde
        INNER JOIN medical_prIn_init_or_pre p ON fk_InitOrPre = p.idInitOrPre 
        INNER JOIN medical_prIn_personal_file pf ON fk_personalLife = pf.idPersonal 
        INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr LEFT JOIN exam_name on idExamName = type
        WHERE mpde.local = :local AND (numEmployee LIKE :word OR name LIKE :word) 
        ORDER BY idExam ASC LIMIT 10;
       ');
       $sql->bindParam(':word',$word,PDO::PARAM_STR);
       $sql->bindParam(':local',$input[1],PDO::PARAM_STR);
       $sql ->execute();
       return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function get_paginator($page, $search){
        
        if($search == 1){
        //buscar
        $word = '%'.$page['word'].'%';
        $sql = $this->connect()->prepare('
            SELECT `idExam`,numEmployee, name, datetime_modification, examName 
            FROM medical_prIn_det_exam as mpde
            INNER JOIN medical_prIn_init_or_pre p ON fk_InitOrPre = p.idInitOrPre 
            INNER JOIN medical_prIn_personal_file pf ON fk_personalLife = pf.idPersonal 
            INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr LEFT JOIN exam_name on idExamName = type
            WHERE mpde.local = :local AND numEmployee LIKE :word OR name LIKE :word ORDER BY idExam ASC LIMIT 10 OFFSET :amount;
        ');
        $sql->bindParam(':amount',$page['amount'],PDO::PARAM_INT);
        $sql->bindParam(':local',$page['local'],PDO::PARAM_INT);
        $sql->bindParam(':word',$word,PDO::PARAM_STR);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
        
        }else{
        //todos
        $sql = $this->connect()->prepare('
            SELECT `idExam`,numEmployee, name, datetime_modification, examName 
            FROM medical_prIn_det_exam as mpde
            INNER JOIN medical_prIn_init_or_pre p ON fk_InitOrPre = p.idInitOrPre 
            INNER JOIN medical_prIn_personal_file pf ON fk_personalLife = pf.idPersonal 
            INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr LEFT JOIN exam_name on idExamName = type 
            WHERE mpde.local = :local
            ORDER BY idExam ASC LIMIT 10 OFFSET :amount;
        ');
        $sql->bindParam(':amount',$page['amount'],PDO::PARAM_INT);
        $sql->bindParam(':local',$page['local'],PDO::PARAM_INT);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
        }
       
       
       
    }
    function delete_exam($id){
        $sql = $this->connect()->prepare('
            DELETE FROM `medical_prIn_det_exam` WHERE idDetExamInPr = (SELECT fk_initial_pre_entry FROM exams WHERE idExam = :id)
        ');
        $sql->bindParam(':id',$id,PDO::PARAM_INT);
        return $sql ->execute();
       
    }
    
    function update_dateTimeExam($id){
        
        $sql = $this->connect()->prepare('
            UPDATE `medical_prIn_det_exam` SET datetime_modification = NOW() WHERE idDetExamInPr = (SELECT fk_initial_pre_entry FROM exams WHERE idExam = :id)
        ');
        $sql->bindParam(':id',$id,PDO::PARAM_INT);
        return $sql ->execute();
       
    }
    
    function get_allPagesPaginator($page, $search){
        if($search == 1){
        //echo 'hola';
        //buscar
        $word = '%'.$page['word'].'%';
        $sql = $this->connect()->prepare('
            SELECT count(*) cantidad
            FROM medical_prIn_det_exam as mpde
            INNER JOIN medical_prIn_init_or_pre p ON fk_InitOrPre = p.idInitOrPre 
            INNER JOIN medical_prIn_personal_file pf ON fk_personalLife = pf.idPersonal 
            INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr LEFT JOIN exam_name on idExamName = type
            WHERE mpde.local = :local AND (numEmployee LIKE :word OR name LIKE :word) ORDER BY idExam ASC;
        ');
        $sql->bindParam(':word',$word,PDO::PARAM_STR);
        $sql->bindParam(':local',$page['local'],PDO::PARAM_INT);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
        
        }else{
        //todos
        $sql = $this->connect()->prepare('
            SELECT count(*) cantidad 
            FROM medical_prIn_det_exam as mpde
            INNER JOIN medical_prIn_init_or_pre p ON fk_InitOrPre = p.idInitOrPre 
            INNER JOIN medical_prIn_personal_file pf ON fk_personalLife = pf.idPersonal 
            INNER JOIN exams ON fk_initial_pre_entry = idDetExamInPr LEFT JOIN exam_name on idExamName = type 
            WHERE mpde.local = :local
            ORDER BY idExam ASC;
        ');
        $sql->bindParam(':local',$page['local'],PDO::PARAM_INT);
        $sql ->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
        }
       
       
       
    }
    
   
}