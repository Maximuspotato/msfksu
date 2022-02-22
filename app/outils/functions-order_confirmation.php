<?php

//require_once('domxml-php4-to-php5.php');

function query_orderconfirmation_unifield() {
	// in:   rien
	// out:  la query de base pour les order confirmations pour unifield
	// (utilisée pour generer 2 types de XML: du normal et du spreadsheet pour excel)


	$query = "SELECT INFO_TETE_ALL_OP.CCT_REF_CMDE_CLI1,
	INFO_TETE_ALL_OP.CCT_REF_CMDE_CLI2,
	INFO_TETE_ALL_OP.MTR_LIB,
	INFO_TETE_ALL_OP.CCT_ADR1_DISP,
	INFO_TETE_ALL_OP.CCT_ADR23_DISP,
	INFO_TETE_ALL_OP.CCT_POSTAL_DISP,
	INFO_TETE_ALL_OP.CCT_VILLE_DISP,
	INFO_TETE_ALL_OP.CCT_NOM_DISP,
	INFO_TETE_ALL_OP.CLI_LAN_CODE,
	TO_CHAR(INFO_TETE_ALL_OP.MAX_CCT_DT_CMDE,'YYYY-MM-DD') MAX_CCT_DT_CMDE,
	INFO_TETE_ALL_OP.ALL_CCT_NO,
	TO_CHAR(INFO_TETE_ALL_OP.MAX_CCT_DT_PREV_LIV,'YYYY-MM-DD') MAX_CCT_DT_PREV_LIV,
	TO_CHAR(INFO_TETE_ALL_OP.MAX_CCT_DT_FERM,'YYYY-MM-DD') MAX_CCT_DT_FERM,
	MAX_CCT_DT_FERM MAX_CCT_DT_FERM_DATE,
	INFO_TETE_ALL_OP.CCT_DEV_CODE,
	XN_CMDE_CLI_LIGNE.CCL_DES2,
	XN_CMDE_CLI_LIGNE.OP_NO_LIGNE,
	XN_CMDE_CLI_LIGNE.CCL_ART_CODE,
	CASE WHEN INFO_TETE_ALL_OP.CLI_LAN_CODE = 'E' AND XN_ART_LANGUE.ARL_DES1 IS NOT NULL THEN XN_ART_LANGUE.ARL_DES1 ELSE XN_CMDE_CLI_LIGNE.CCL_DES1 END DES1,
	SUM(XN_CMDE_CLI_LIGNE.CCL_QTE_CMDE) SUM_QTE_CMDE,
	ROUND(SUM(XN_CMDE_CLI_LIGNE.CCL_MT_HT_LIGNE)/SUM(XN_CMDE_CLI_LIGNE.CCL_QTE_CMDE),4) PRIX_UNITAIRE,
	TO_CHAR(MAX(XN_CMDE_CLI_LIGNE.CCL_DT_LIV_PREV),'YYYY-MM-DD') MAX_DT_LIV_PREV,
	TO_CHAR(MAX(XN_CMDE_CLI_LIGNE.PFB_DT_FAB),'YYYY-MM-DD') MAX_PLANIF,
	'PCE' PRODUCT_UOM

	FROM (


	SELECT INFO_TETE.CCT_REF_CMDE_CLI1,
	INFO_TETE.CCT_REF_CMDE_CLI2,
	INFO_TETE.MTR_LIB,
	INFO_TETE.CCT_ADR1_DISP,
	INFO_TETE.CCT_ADR23_DISP,
	INFO_TETE.CCT_POSTAL_DISP,
	INFO_TETE.CCT_VILLE_DISP,
	INFO_TETE.CCT_NOM_DISP,
	INFO_TETE.CLI_LAN_CODE,
	INFO_TETE.CCT_DEV_CODE,
	MAX(XN_CMDE_CLI_TETE.CCT_DT_CMDE) MAX_CCT_DT_CMDE,
	--TO_CHAR(WM_CONCAT(DISTINCT XN_CMDE_CLI_TETE.CCT_NO)) ALL_CCT_NO,
	TO_CHAR(LISTAGG(XN_CMDE_CLI_TETE.CCT_NO, ',') WITHIN GROUP(ORDER BY XN_CMDE_CLI_TETE.CCT_NO)) ALL_CCT_NO,
	MAX(XN_CMDE_CLI_TETE.CCT_DT_PREV_LIV) MAX_CCT_DT_PREV_LIV,
	MAX(XN_CMDE_CLI_TETE.CCT_DT_FERM) MAX_CCT_DT_FERM

	FROM            
	(
	SELECT EXTFCT_CCT_REF_CMDE_CLI1(XN_CMDE_CLI_TETE.CCT_REF_CMDE_CLI1) CCT_REF_CMDE_CLI1,
	XN_CMDE_CLI_TETE.CCT_REF_CMDE_CLI2,
	XN_MODE_TRANSP.MTR_LIB,
	XN_CMDE_CLI_TETE.CCT_ADR1_DISP,
	XN_CMDE_CLI_TETE.CCT_ADR2_DISP || XN_CMDE_CLI_TETE.CCT_ADR3_DISP CCT_ADR23_DISP,
	XN_CMDE_CLI_TETE.CCT_POSTAL_DISP,
	XN_CMDE_CLI_TETE.CCT_VILLE_DISP,
	XN_CMDE_CLI_TETE.CCT_NOM_DISP,
	XN_CLI.CLI_LAN_CODE,
	XN_CMDE_CLI_TETE.CCT_DEV_CODE

	FROM(            

	SELECT MIN(XN_CMDE_CLI_TETE.CCT_NO) FIRST_CCT_NO
	FROM XN_CMDE_CLI_TETE
	WHERE EXTFCT_CCT_REF_CMDE_CLI1(CCT_REF_CMDE_CLI1) = :ref
	AND XN_CMDE_CLI_TETE.CCT_TYD_CODE in ('CS','CC')

	) FIRST_XN_CMDE_CLI_TETE,
	XN_CMDE_CLI_TETE,  
	XN_MODE_TRANSP,
	XN_CLI

	WHERE FIRST_XN_CMDE_CLI_TETE.FIRST_CCT_NO = XN_CMDE_CLI_TETE.CCT_NO

	AND XN_CMDE_CLI_TETE.CCT_MTR_CODE = XN_MODE_TRANSP.MTR_CODE(+) 

	AND XN_CMDE_CLI_TETE.CCT_CLI_CODE_DISP = XN_CLI.CLI_CODE(+)      
	) INFO_TETE,
	XN_CMDE_CLI_TETE

	WHERE INFO_TETE.CCT_REF_CMDE_CLI1 = EXTFCT_CCT_REF_CMDE_CLI1(XN_CMDE_CLI_TETE.CCT_REF_CMDE_CLI1)        

	GROUP BY INFO_TETE.CCT_REF_CMDE_CLI1,
	INFO_TETE.CCT_REF_CMDE_CLI2,
	INFO_TETE.MTR_LIB,
	INFO_TETE.CCT_ADR1_DISP,
	INFO_TETE.CCT_ADR23_DISP,
	INFO_TETE.CCT_POSTAL_DISP,
	INFO_TETE.CCT_VILLE_DISP,
	INFO_TETE.CCT_NOM_DISP,
	INFO_TETE.CLI_LAN_CODE ,
	INFO_TETE.CCT_DEV_CODE   

	) INFO_TETE_ALL_OP,
	XN_CMDE_CLI_TETE,
	(SELECT XN_CMDE_CLI_LIGNE.CCL_CCT_NO,
		XN_CMDE_CLI_LIGNE.CCL_DEP_CODE,
		XN_CMDE_CLI_LIGNE.CCL_DEP_SOC_CODE,
		XN_CMDE_CLI_LIGNE.CCL_NO_LIGNE,
		XN_CMDE_CLI_LIGNE.CCL_DES2,
		XN_CMDE_CLI_LIGNE.CCL_CCT_NO || XN_CMDE_CLI_LIGNE.CCL_NO_ORDRE OP_NO_LIGNE,
		XN_CMDE_CLI_LIGNE.CCL_ART_CODE,
		XN_CMDE_CLI_LIGNE.CCL_ART_VAR1,
		XN_CMDE_CLI_LIGNE.CCL_ART_VAR2,
		XN_CMDE_CLI_LIGNE.CCL_ART_VAR3,
		XN_CMDE_CLI_LIGNE.CCL_DES1,
		XN_CMDE_CLI_LIGNE.CCL_QTE_CMDE,
		XN_CMDE_CLI_LIGNE.CCL_MT_HT_LIGNE,
		XN_CMDE_CLI_LIGNE.CCL_DT_LIV_PREV,
		/* BMU: N est plus necessaire suite à la demande de Laura, mais pas envie de re changer toute la requête */
		MAX(TR_PLANIF_FAB.PFB_DT_FAB) PFB_DT_FAB

		FROM XN_CMDE_CLI_LIGNE,TR_PLANIF_FAB
		WHERE XN_CMDE_CLI_LIGNE.CCL_CCT_NO = TR_PLANIF_FAB.PFB_CCL_CCT_NO(+)
		AND XN_CMDE_CLI_LIGNE.CCL_DEP_CODE = TR_PLANIF_FAB.PFB_CCL_DEP_CODE(+)
		AND XN_CMDE_CLI_LIGNE.CCL_DEP_SOC_CODE = TR_PLANIF_FAB.PFB_CCL_DEP_SOC_CODE(+)
		AND XN_CMDE_CLI_LIGNE.CCL_NO_LIGNE = TR_PLANIF_FAB.PFB_CCL_NO_LIGNE(+)

		GROUP BY XN_CMDE_CLI_LIGNE.CCL_CCT_NO,
		XN_CMDE_CLI_LIGNE.CCL_DEP_CODE,
		XN_CMDE_CLI_LIGNE.CCL_DEP_SOC_CODE,
		XN_CMDE_CLI_LIGNE.CCL_NO_LIGNE,
		XN_CMDE_CLI_LIGNE.CCL_DES2,
		XN_CMDE_CLI_LIGNE.CCL_NO_ORDRE,
		XN_CMDE_CLI_LIGNE.CCL_ART_CODE,
		XN_CMDE_CLI_LIGNE.CCL_ART_VAR1,
		XN_CMDE_CLI_LIGNE.CCL_ART_VAR2,
		XN_CMDE_CLI_LIGNE.CCL_ART_VAR3,
		XN_CMDE_CLI_LIGNE.CCL_DES1,
		XN_CMDE_CLI_LIGNE.CCL_QTE_CMDE,
		XN_CMDE_CLI_LIGNE.CCL_MT_HT_LIGNE,
		XN_CMDE_CLI_LIGNE.CCL_DT_LIV_PREV
	) XN_CMDE_CLI_LIGNE,            
	(SELECT * FROM XN_ART_LANGUE WHERE XN_ART_LANGUE.ARL_LAN_CODE = 'E') XN_ART_LANGUE

	WHERE INFO_TETE_ALL_OP.CCT_REF_CMDE_CLI1 = EXTFCT_CCT_REF_CMDE_CLI1(XN_CMDE_CLI_TETE.CCT_REF_CMDE_CLI1)

	AND XN_CMDE_CLI_TETE.CCT_NO = XN_CMDE_CLI_LIGNE.CCL_CCT_NO
	AND XN_CMDE_CLI_TETE.CCT_DEP_CODE = XN_CMDE_CLI_LIGNE.CCL_DEP_CODE
	AND XN_CMDE_CLI_TETE.CCT_DEP_SOC_CODE = XN_CMDE_CLI_LIGNE.CCL_DEP_SOC_CODE       

	AND XN_CMDE_CLI_LIGNE.CCL_ART_CODE = XN_ART_LANGUE.ARL_ART_CODE(+)
	AND XN_CMDE_CLI_LIGNE.CCL_ART_VAR1 = XN_ART_LANGUE.ARL_ART_VAR1(+)     
	AND XN_CMDE_CLI_LIGNE.CCL_ART_VAR2 = XN_ART_LANGUE.ARL_ART_VAR2(+)
	AND XN_CMDE_CLI_LIGNE.CCL_ART_VAR3 = XN_ART_LANGUE.ARL_ART_VAR3(+)

	AND XN_CMDE_CLI_TETE.CCT_TYD_CODE in ('CS','CC')

	GROUP BY INFO_TETE_ALL_OP.CCT_REF_CMDE_CLI1,
	INFO_TETE_ALL_OP.CCT_REF_CMDE_CLI2,
	INFO_TETE_ALL_OP.MTR_LIB,
	INFO_TETE_ALL_OP.CCT_ADR1_DISP,
	INFO_TETE_ALL_OP.CCT_ADR23_DISP,
	INFO_TETE_ALL_OP.CCT_POSTAL_DISP,
	INFO_TETE_ALL_OP.CCT_VILLE_DISP,
	INFO_TETE_ALL_OP.CCT_NOM_DISP,
	INFO_TETE_ALL_OP.CLI_LAN_CODE,
	INFO_TETE_ALL_OP.MAX_CCT_DT_CMDE,
	INFO_TETE_ALL_OP.ALL_CCT_NO,
	INFO_TETE_ALL_OP.MAX_CCT_DT_PREV_LIV,
	INFO_TETE_ALL_OP.MAX_CCT_DT_FERM,
	INFO_TETE_ALL_OP.CCT_DEV_CODE,
	XN_CMDE_CLI_LIGNE.CCL_DES2,
	XN_CMDE_CLI_LIGNE.OP_NO_LIGNE,
	XN_CMDE_CLI_LIGNE.CCL_ART_CODE,
	CASE WHEN INFO_TETE_ALL_OP.CLI_LAN_CODE = 'E' AND XN_ART_LANGUE.ARL_DES1 IS NOT NULL THEN XN_ART_LANGUE.ARL_DES1 ELSE XN_CMDE_CLI_LIGNE.CCL_DES1 END 

	ORDER BY CCT_REF_CMDE_CLI1,CCL_ART_CODE";



	return($query);

}

// -------- -------- -------- -------- -------- -------- -------- -------- -------- -------- -------- 
// -------- -------- -------- -------- -------- -------- -------- -------- -------- -------- -------- 
// -------- -------- -------- -------- -------- -------- -------- -------- -------- -------- -------- 



function get_xml_for_unifield($missionref) {
	// in:   reference mission
	// out:  le contenu du xml de confirmation de cette commande
	
	
	global $c;

	$query=query_orderconfirmation_unifield();

	$stmt = oci_parse($c,$query);
	oci_bind_by_name($stmt,":ref",$missionref);
	ociexecute($stmt, OCI_DEFAULT);
	$nrows=ocifetchstatement($stmt, $resultat,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

	//$filename=ltrim(str_replace('/','_',$_REQUEST['order_ref']));
	//$filename=str_replace(' ','',$filename);

	$doc = domxml_new_doc('1.0');


	$root = $doc->create_element("data");
	$doc->append_child($root);

	$purchase = $doc->create_element("record");
	$purchase->set_attribute("model","purchase.order");
	$purchase->set_attribute("key","name");
	$root->append_child($purchase);

	$name = $doc->create_element("field");
	$name->set_attribute("name","name");
	$name->append_child($doc->create_text_node($resultat[0]['CCT_REF_CMDE_CLI1']));
	$purchase->append_child($name);

	$order_type = $doc->create_element("field");
	$order_type->set_attribute("name","order_type");
	$order_type->append_child($doc->create_text_node('Regular'));
	$purchase->append_child($order_type);

	$categ = $doc->create_element("field");
	$categ->set_attribute("name","categ");
	$categ->append_child($doc->create_text_node('Medical'));
	$purchase->append_child($categ);

	$date_order = $doc->create_element("field");
	$date_order->set_attribute("name","date_order");
	$date_order->append_child($doc->create_text_node($resultat[0]['MAX_CCT_DT_CMDE']));
	$purchase->append_child($date_order);

	$partner_ref = $doc->create_element("field");
	$partner_ref->set_attribute("name","partner_ref");
	$partner_ref->append_child($doc->create_text_node($resultat[0]['ALL_CCT_NO']));
	$purchase->append_child($partner_ref);

	$details = $doc->create_element("field");
	$details->set_attribute("name","details");
	$purchase->append_child($details);
	
	$stockTakeDate = $doc->create_element("field");
	$stockTakeDate->set_attribute("name","stock_take_date");
	$purchase->append_child($stockTakeDate);
	
	$delivery_requested_date = $doc->create_element("field");
	$delivery_requested_date->set_attribute("name","delivery_requested_date");
	$delivery_requested_date->append_child($doc->create_text_node($resultat[0]['MAX_CCT_DT_PREV_LIV']));
	$purchase->append_child($delivery_requested_date);

	$transport_type = $doc->create_element("field");
	$transport_type->set_attribute("name","transport_type");
	$transport_type->append_child($doc->create_text_node(ucfirst(strtolower($resultat[0]['MTR_LIB']))));
	$purchase->append_child($transport_type);

	$ready_to_ship_date = $doc->create_element("field");
	$ready_to_ship_date->set_attribute("name","ready_to_ship_date");
	$ready_to_ship_date->append_child($doc->create_text_node($resultat[0]['MAX_CCT_DT_FERM']));
	$purchase->append_child($ready_to_ship_date);

	$dest_address_id = $doc->create_element("field");
	$dest_address_id->set_attribute("name","dest_address_id");
	$dest_address_id->set_attribute("key","name,parent.partner_id");
	$purchase->append_child($dest_address_id);
	
	$delivery_name = $doc->create_element("field");
	$delivery_name->set_attribute("name","delivery_name");
	$dest_address_id->append_child($delivery_name);

	$delivery_address = $doc->create_element("field");
	$delivery_address->set_attribute("name","delivery_address");
	$dest_address_id->append_child($delivery_address);

	$customer_name = $doc->create_element("field");
	$customer_name->set_attribute("name","customer_name");
	$dest_address_id->append_child($customer_name);

	$customer_address = $doc->create_element("field");
	$customer_address->set_attribute("name","customer_address");
	$dest_address_id->append_child($customer_address);
/*
	$name2 = $doc->create_element("field");
	$name2->set_attribute("name","name");
	$dest_address_id->append_child($name2);

	$street = $doc->create_element("field");
	$street->set_attribute("name","street");
	$street->append_child($doc->create_text_node($resultat[0]['CCT_ADR1_DISP']));
	$dest_address_id->append_child($street);

	$street2 = $doc->create_element("field");
	$street2->set_attribute("name","street2");
	$street2->append_child($doc->create_text_node($resultat[0]['CCT_ADR23_DISP']));
	$dest_address_id->append_child($street2);

	$zipCode = $doc->create_element("field");
	$zipCode->set_attribute("name","zip");
	$zipCode->append_child($doc->create_text_node($resultat[0]['CCT_POSTAL_DISP']));
	$dest_address_id->append_child($zipCode);

	$city = $doc->create_element("field");
	$city->set_attribute("name","city");
	$city->append_child($doc->create_text_node($resultat[0]['CCT_VILLE_DISP']));
	$dest_address_id->append_child($city);

	$country_id = $doc->create_element("field");
	$country_id->set_attribute("name","country_id");
	$country_id->set_attribute("key","name");
	$nameCountry = $doc->create_element("field");
	$nameCountry->set_attribute("name","name");
	$nameCountry->append_child($doc->create_text_node($resultat[0]['CCT_NOM_DISP']));
	$country_id->append_child($nameCountry);
	$dest_address_id->append_child($country_id);
*/
	$shipment_date = $doc->create_element("field");
	$shipment_date->set_attribute("name","shipment_date");
	$purchase->append_child($shipment_date);

	$notes = $doc->create_element("field");
	$notes->set_attribute("name","notes");
	//20171026 demande de Matteo de retirer les hard codings ticket 4120
	//$notes->append_child($doc->create_text_node('THIS IS THE NOTE HEADER LEVEL'));
	$purchase->append_child($notes);

	$origin = $doc->create_element("field");
	$origin->set_attribute("name","origin");
	$origin->append_child($doc->create_text_node($resultat[0]['CCT_REF_CMDE_CLI2']));
	$purchase->append_child($origin);

	$project_ref = $doc->create_element("field");
	$project_ref->set_attribute("name","project_ref");
	$purchase->append_child($project_ref);

	$message_esc = $doc->create_element("field");
	$message_esc->set_attribute("name","message_esc");
	//$message_esc->append_child($doc->create_text_node('HEADER MESSAGE FROM ESC'));
	$purchase->append_child($message_esc);
	
	$related_sourcing_id = $doc->create_element("field");
	$related_sourcing_id->set_attribute("name","related_sourcing_id");
	$purchase->append_child($related_sourcing_id);
	
	$analytic_distribution_id = $doc->create_element("field");
	$analytic_distribution_id->set_attribute("name","analytic_distribution_id");
	$purchase->append_child($analytic_distribution_id);

	$ad_destination_name = $doc->create_element("field");
	$ad_destination_name->set_attribute("name","ad_destination_name");
	$analytic_distribution_id->append_child($ad_destination_name);

	$ad_cost_center_name = $doc->create_element("field");
	$ad_cost_center_name->set_attribute("name","ad_cost_center_name");
	$analytic_distribution_id->append_child($ad_cost_center_name);

	$ad_percentage = $doc->create_element("field");
	$ad_percentage->set_attribute("name","ad_percentage");
	$analytic_distribution_id->append_child($ad_percentage);

	$ad_subtotal = $doc->create_element("field");
	$ad_subtotal->set_attribute("name","ad_subtotal");
	$analytic_distribution_id->append_child($ad_subtotal);

	$order_line = $doc->create_element("field");
	$order_line->set_attribute("name","order_line");
	$purchase->append_child($order_line);

	foreach($resultat as $result){
		$record = $doc->create_element("record");
		$order_line->append_child($record);

		$line_number = $doc->create_element("field");
		$line_number->set_attribute("name","line_number");
		$line_number->append_child($doc->create_text_node($result['CCL_DES2']));
		$record->append_child($line_number);

		$external_ref = $doc->create_element("field");
		$external_ref->set_attribute("name","external_ref");
		if($result['CCL_DES2'] == ""){
			$external_ref->append_child($doc->create_text_node($result['OP_NO_LIGNE']));
		}
		$record->append_child($external_ref);

		$product_id = $doc->create_element("field");
		$product_id->set_attribute("name","product_id");
		$product_id->set_attribute("key","default_code,name");
		$record->append_child($product_id);

		$product_code = $doc->create_element("field");
		$product_code->set_attribute("name","product_code");
		$product_code->append_child($doc->create_text_node($result['CCL_ART_CODE']));
		$product_id->append_child($product_code);

		$product_name = $doc->create_element("field");
		$product_name->set_attribute("name","product_name");
		$product_name->append_child($doc->create_text_node(utf8_decode($result['DES1'])));
		$product_id->append_child($product_name);

		$product_qty = $doc->create_element("field");
		$product_qty->set_attribute("name","product_qty");
		$product_qty->append_child($doc->create_text_node($result['SUM_QTE_CMDE']));
		$record->append_child($product_qty);

		$product_uom = $doc->create_element("field");
		$product_uom->set_attribute("name","product_uom");
		$product_uom->set_attribute("key","name");
		$record->append_child($product_uom);

		$name_product_uom = $doc->create_element("field");
		$name_product_uom->set_attribute("name","name");
		$name_product_uom->append_child($doc->create_text_node('PCE'));
		$product_uom->append_child($name_product_uom);

		$price_unit = $doc->create_element("field");
		$price_unit->set_attribute("name","price_unit");
		$price_unit->append_child($doc->create_text_node(number_format($result['PRIX_UNITAIRE'],4,".","")));
		$record->append_child($price_unit);

		$currency_id = $doc->create_element("field");
		$currency_id->set_attribute("name","currency_id");
		$currency_id->set_attribute("key","name");
		$record->append_child($currency_id);

		$name_currency_id = $doc->create_element("field");
		$name_currency_id->set_attribute("name","name");
		$name_currency_id->append_child($doc->create_text_node($result['CCT_DEV_CODE']));
		$currency_id->append_child($name_currency_id);

		$origin = $doc->create_element("field");
		$origin->set_attribute("name","origin");
		$origin->append_child($doc->create_text_node($resultat[0]['CCT_REF_CMDE_CLI2']));
		$record->append_child($origin);
		
		$stock_take_date = $doc->create_element("field");
		$stock_take_date->set_attribute("name","stock_take_date");
		$record->append_child($stock_take_date);
		
		$date_planned = $doc->create_element("field");
		$date_planned->set_attribute("name","date_planned");
		//$date_planned->append_child($doc->create_text_node($result['MAX_PLANIF']));
		/* Demandé par Laura par mail, ils ont besoin de la date demandée par le client (normalement par ligne mais on a pas l info dans Nodhos => prend la tête) et non pas la date planif qui est propre à MSFSupply */
		$date_planned->append_child($doc->create_text_node($result['MAX_CCT_DT_PREV_LIV']));
		$record->append_child($date_planned);

		$confirmed_delivery_date = $doc->create_element("field");
		$confirmed_delivery_date->set_attribute("name","confirmed_delivery_date");
		$confirmed_delivery_date->append_child($doc->create_text_node($result['MAX_DT_LIV_PREV']));
		$record->append_child($confirmed_delivery_date);

		$nomen_manda_0 = $doc->create_element("field");
		$nomen_manda_0->set_attribute("name","nomen_manda_0");
		$nomen_manda_0->set_attribute("key","name");
		$record->append_child($nomen_manda_0);

		$name_nomen_manda_0 = $doc->create_element("field");
		$name_nomen_manda_0->set_attribute("name","name");
		$nomen_manda_0->append_child($name_nomen_manda_0);

		$nomen_manda_1 = $doc->create_element("field");
		$nomen_manda_1->set_attribute("name","nomen_manda_1");
		$nomen_manda_1->set_attribute("key","name");
		$record->append_child($nomen_manda_1);

		$name_nomen_manda_1 = $doc->create_element("field");
		$name_nomen_manda_1->set_attribute("name","name");
		$nomen_manda_1->append_child($name_nomen_manda_1);

		$nomen_manda_2 = $doc->create_element("field");
		$nomen_manda_2->set_attribute("name","nomen_manda_2");
		$nomen_manda_2->set_attribute("key","name");
		$record->append_child($nomen_manda_2);

		$name_nomen_manda_2 = $doc->create_element("field");
		$name_nomen_manda_2->set_attribute("name","name");
		$nomen_manda_2->append_child($name_nomen_manda_2);

		$comment = $doc->create_element("field");
		$comment->set_attribute("name","comment");
		//$comment->append_child($doc->create_text_node('THIS IS THE COMMENT'));
		$record->append_child($comment);

		$notes2 = $doc->create_element("field");
		$notes2->set_attribute("name","notes");
		//$notes2->append_child($doc->create_text_node('THIS THE NOTE AT ITEM LEVEL L1'));
		$record->append_child($notes2);

		$project_ref = $doc->create_element("field");
		$project_ref->set_attribute("name","project_ref");
		$record->append_child($project_ref);

		$message_esc1 = $doc->create_element("field");
		$message_esc1->set_attribute("name","message_esc1");
		//$message_esc1->append_child($doc->create_text_node('ITEM MESSAGE ONE FROM ESC'));
		$record->append_child($message_esc1);

		$message_esc2 = $doc->create_element("field");
		$message_esc2->set_attribute("name","message_esc2");
		//$message_esc2->append_child($doc->create_text_node('ITEM MESSAGE TWO FROM ESC'));
		$record->append_child($message_esc2);

		$analytic_distribution_id = $doc->create_element("field");
		$analytic_distribution_id->set_attribute("name","analytic_distribution_id");
		$record->append_child($analytic_distribution_id);
		
		$ad_destination_name = $doc->create_element("field");
		$ad_destination_name->set_attribute("name","ad_destination_name");
		$analytic_distribution_id->append_child($ad_destination_name);
		
		$ad_cost_center_name = $doc->create_element("field");
		$ad_cost_center_name->set_attribute("name","ad_cost_center_name");
		$analytic_distribution_id->append_child($ad_cost_center_name);
		
		$ad_percentage = $doc->create_element("field");
		$ad_percentage->set_attribute("name","ad_percentage");
		$analytic_distribution_id->append_child($ad_percentage);
		
		$ad_subtotal = $doc->create_element("field");
		$ad_subtotal->set_attribute("name","ad_subtotal");
		$analytic_distribution_id->append_child($ad_subtotal);
	}

	return($doc->dump_mem(true));

}


// -------- -------- -------- -------- -------- -------- -------- -------- -------- -------- -------- 
// -------- -------- -------- -------- -------- -------- -------- -------- -------- -------- -------- 
// -------- -------- -------- -------- -------- -------- -------- -------- -------- -------- -------- 

function get_xml_spreadsheet_for_unifield($missionref) {
	//global $c;

	$query=query_orderconfirmation_unifield();

	$stmt = oci_parse($GLOBALS['c'],$query);
	oci_bind_by_name($stmt,":ref",$missionref);
	ociexecute($stmt, OCI_DEFAULT);
	$nrows=ocifetchstatement($stmt, $resultat,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

//------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------
//Partie spreadsheet
//------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------

	$xmlns = "urn:schemas-microsoft-com:office:spreadsheet";
	$xmlns_o = "urn:schemas-microsoft-com:office:office";
	$xmlns_x = "urn:schemas-microsoft-com:office:excel";
	$xmlns_ss = "urn:schemas-microsoft-com:office:spreadsheet";
	$xmlns_html = "http://www.w3.org/TR/REC-html40";

	/*$xml = '<?mso-application progid="Excel.Sheet"?>'.
	'<Workbook xmlns="'.$xmlns.'" xmlns:o="'.$xmlns_o.'" xmlns:x="'.$xmlns_x.'" xmlns:ss="'.$xmlns_ss.'" xmlns:html="'.$xmlns_html.'"/>
	';*/
	$xml = '<?mso-application progid="Excel.Sheet"?>'.'<ss:Workbook xmlns:ss="'.$xmlns_ss.'" xmlns:x="'.$xmlns_x.'"/>';



	$Workbook = new SimpleXMLElement($xml);


	//--------------------------------------------------------------------------------------------------------------------------------
	//DocumentProperties
	//--------------------------------------------------------------------------------------------------------------------------------
	$documentProperties = $Workbook->addChild('DocumentProperties');
	$documentProperties->addAttribute('ss:xmlns', 'urn:schemas-microsoft-com:office:office', $xmlns);

	$author = $documentProperties->addChild('Author', 'MSFUser', $xmlns);
	$lastAuthor = $documentProperties->addChild('LastAuthor', 'MSF-Supply', $xmlns);
	$created = $documentProperties->addChild('Created', date('Y-m-d').'T'.date('H:i:s').'Z', $xmlns);
	$company = $documentProperties->addChild('Company', 'Medecins Sans Frontieres', $xmlns);
	$version = $documentProperties->addChild('Version', '14.00', $xmlns);


	//--------------------------------------------------------------------------------------------------------------------------------
	//OfficeDocumentSettings
	//--------------------------------------------------------------------------------------------------------------------------------
	$officeDocumentSettings = $Workbook->addChild('OfficeDocumentSettings');
	$officeDocumentSettings->addAttribute('ss:xmlns', 'urn:schemas-microsoft-com:office:office', $xmlns);


	//--------------------------------------------------------------------------------------------------------------------------------
	//ExcelWorkbook
	//--------------------------------------------------------------------------------------------------------------------------------
	$excelWorkbook = $Workbook->addChild('ExcelWorkbook');
	$excelWorkbook->addAttribute('ss:xmlns', 'urn:schemas-microsoft-com:office:excel', $xmlns);

	$windowHeight = $excelWorkbook->addChild('WindowHeight', '13170', $xmlns);
	$windowWidth = $excelWorkbook->addChild('WindowWidth', '19020', $xmlns);
	$windowTopX = $excelWorkbook->addChild('WindowTopX', '120', $xmlns);
	$windowTopY = $excelWorkbook->addChild('WindowTopY', '60', $xmlns);
	$protectStructure = $excelWorkbook->addChild('ProtectStructure', 'False', $xmlns);
	$protectWindows = $excelWorkbook->addChild('ProtectWindows', 'False', $xmlns);


	//--------------------------------------------------------------------------------------------------------------------------------
	//Styles
	//--------------------------------------------------------------------------------------------------------------------------------
	$styles = $Workbook->addChild('Styles'); 

	//--------------------------------------------------------------------------------------------------------------------------------
	//Styles Default
	//--------------------------------------------------------------------------------------------------------------------------------
	$stylesDefault = $styles->addChild('Style');
	$stylesDefault->addAttribute('ss:ID', 'Default', $xmlns_ss);
	$stylesDefault->addAttribute('ss:Name', 'Normal', $xmlns_ss);

	$alignment = $stylesDefault->addChild('Alignment', '', $xmlns);
	$alignment->addAttribute('ss:Vertical', 'Bottom', $xmlns_ss);

	$borders = $stylesDefault->addChild('Borders', '', $xmlns);

	$font = $stylesDefault->addChild('Font', '', $xmlns);
	$font->addAttribute('ss:FontName', 'Calibri', $xmlns_ss);
	$font->addAttribute('x:Family', 'Swiss', $xmlns_x);
	$font->addAttribute('ss:Size', '11', $xmlns_ss);
	$font->addAttribute('ss:Color', '#000000', $xmlns_ss);

	$interior = $stylesDefault->addChild('Interior', '', $xmlns);
	$numberFormat = $stylesDefault->addChild('NumberFormat', '', $xmlns);
	$protection = $stylesDefault->addChild('Protection', '', $xmlns);


	//--------------------------------------------------------------------------------------------------------------------------------
	//Styles m44381952
	//--------------------------------------------------------------------------------------------------------------------------------
	$stylesDefault = $styles->addChild('Style');
	$stylesDefault->addAttribute('ss:ID', 'm44381952', $xmlns_ss);

	$alignment = $stylesDefault->addChild('Alignment', '', $xmlns);
	$alignment->addAttribute('ss:Horizontal', 'Center', $xmlns_ss);
	$alignment->addAttribute('ss:Vertical', 'Center', $xmlns_ss);
	$alignment->addAttribute('ss:WrapText', '1', $xmlns_ss);

	$borders = $stylesDefault->addChild('Borders', '', $xmlns);

	$tabPosition = array('Bottom','Left','Right','Top');
	foreach($tabPosition as $unePostion){
		$border = $borders->addChild('Border', '', $xmlns);
		$border->addAttribute('ss:Position', $unePostion, $xmlns_ss);
		$border->addAttribute('ss:LineStyle', 'Continuous', $xmlns_ss);
		$border->addAttribute('ss:Weight', '1', $xmlns_ss);
	}

	$font = $stylesDefault->addChild('Font', '', $xmlns);
	$font->addAttribute('ss:FontName', 'Calibri', $xmlns_ss);
	$font->addAttribute('x:Family', 'Swiss', $xmlns_x);
	$font->addAttribute('ss:Size', '11', $xmlns_ss);
	$font->addAttribute('ss:Color', '#000000', $xmlns_ss);

	$interior = $stylesDefault->addChild('Interior', '', $xmlns);
	$interior->addAttribute('ss:Color', '#FFCC99', $xmlns_ss);
	$interior->addAttribute('ss:Pattern', 'Solid', $xmlns_ss);

	$numberFormat = $stylesDefault->addChild('NumberFormat', '', $xmlns);

	$protection = $stylesDefault->addChild('Protection', '', $xmlns);

	//--------------------------------------------------------------------------------------------------------------------------------
	//Styles s62
	//--------------------------------------------------------------------------------------------------------------------------------
	$stylesDefault = $styles->addChild('Style');
	$stylesDefault->addAttribute('ss:ID', 's62', $xmlns_ss);

	$alignment = $stylesDefault->addChild('Alignment', '', $xmlns);
	$alignment->addAttribute('ss:Horizontal', 'Center', $xmlns_ss);
	$alignment->addAttribute('ss:Vertical', 'Center', $xmlns_ss);
	$alignment->addAttribute('ss:WrapText', '1', $xmlns_ss);

	$borders = $stylesDefault->addChild('Borders', '', $xmlns);

	$tabPosition = array('Bottom','Left','Right','Top');
	foreach($tabPosition as $unePostion){
		$border = $borders->addChild('Border', '', $xmlns);
		$border->addAttribute('ss:Position', $unePostion, $xmlns_ss);
		$border->addAttribute('ss:LineStyle', 'Continuous', $xmlns_ss);
		$border->addAttribute('ss:Weight', '1', $xmlns_ss);
	}

	$font = $stylesDefault->addChild('Font', '', $xmlns);
	$font->addAttribute('ss:FontName', 'Calibri', $xmlns_ss);
	$font->addAttribute('x:Family', 'Swiss', $xmlns_x);
	$font->addAttribute('ss:Size', '11', $xmlns_ss);
	$font->addAttribute('ss:Color', '#000000', $xmlns_ss);

	$interior = $stylesDefault->addChild('Interior', '', $xmlns);
	$interior->addAttribute('ss:Color', '#FFCC99', $xmlns_ss);
	$interior->addAttribute('ss:Pattern', 'Solid', $xmlns_ss);

	$numberFormat = $stylesDefault->addChild('NumberFormat', '', $xmlns);

	$protection = $stylesDefault->addChild('Protection', '', $xmlns);

	//--------------------------------------------------------------------------------------------------------------------------------
	//Styles s63
	//--------------------------------------------------------------------------------------------------------------------------------
	$stylesDefault = $styles->addChild('Style');
	$stylesDefault->addAttribute('ss:ID', 's63', $xmlns_ss);

	$alignment = $stylesDefault->addChild('Alignment', '', $xmlns);
	$alignment->addAttribute('ss:Horizontal', 'Center', $xmlns_ss);
	$alignment->addAttribute('ss:Vertical', 'Center', $xmlns_ss);
	$alignment->addAttribute('ss:WrapText', '1', $xmlns_ss);

	$borders = $stylesDefault->addChild('Borders', '', $xmlns);

	$tabPosition = array('Bottom','Left','Right','Top');
	foreach($tabPosition as $unePostion){
		$border = $borders->addChild('Border', '', $xmlns);
		$border->addAttribute('ss:Position', $unePostion, $xmlns_ss);
		$border->addAttribute('ss:LineStyle', 'Continuous', $xmlns_ss);
		$border->addAttribute('ss:Weight', '1', $xmlns_ss);
	}

	$font = $stylesDefault->addChild('Font', '', $xmlns);
	$font->addAttribute('ss:FontName', 'Calibri', $xmlns_ss);
	$font->addAttribute('x:Family', 'Swiss', $xmlns_x);
	$font->addAttribute('ss:Size', '11', $xmlns_ss);
	$font->addAttribute('ss:Color', '#000000', $xmlns_ss);

	$interior = $stylesDefault->addChild('Interior', '', $xmlns);

	$numberFormat = $stylesDefault->addChild('NumberFormat', '', $xmlns);

	$protection = $stylesDefault->addChild('Protection', '', $xmlns);
	$protection->addAttribute('ss:Protected', '0', $xmlns_ss);

	//--------------------------------------------------------------------------------------------------------------------------------
	//Styles s64
	//--------------------------------------------------------------------------------------------------------------------------------
	$stylesDefault = $styles->addChild('Style');
	$stylesDefault->addAttribute('ss:ID', 's64', $xmlns_ss);

	$alignment = $stylesDefault->addChild('Alignment', '', $xmlns);
	$alignment->addAttribute('ss:Horizontal', 'Center', $xmlns_ss);
	$alignment->addAttribute('ss:Vertical', 'Center', $xmlns_ss);
	$alignment->addAttribute('ss:WrapText', '1', $xmlns_ss);

	$borders = $stylesDefault->addChild('Borders', '', $xmlns);

	$tabPosition = array('Bottom','Left','Right','Top');
	foreach($tabPosition as $unePostion){
		$border = $borders->addChild('Border', '', $xmlns);
		$border->addAttribute('ss:Position', $unePostion, $xmlns_ss);
		$border->addAttribute('ss:LineStyle', 'Continuous', $xmlns_ss);
		$border->addAttribute('ss:Weight', '1', $xmlns_ss);
	}

	$font = $stylesDefault->addChild('Font', '', $xmlns);
	$font->addAttribute('ss:FontName', 'Calibri', $xmlns_ss);
	$font->addAttribute('x:Family', 'Swiss', $xmlns_x);
	$font->addAttribute('ss:Size', '11', $xmlns_ss);
	$font->addAttribute('ss:Color', '#000000', $xmlns_ss);

	$interior = $stylesDefault->addChild('Interior', '', $xmlns);

	$numberFormat = $stylesDefault->addChild('NumberFormat', 'Short Date', $xmlns);

	$protection = $stylesDefault->addChild('Protection', '', $xmlns);
	$protection->addAttribute('ss:Protected', '0', $xmlns_ss);

	//--------------------------------------------------------------------------------------------------------------------------------
	//Worksheet
	//--------------------------------------------------------------------------------------------------------------------------------
	$worksheet = $Workbook->addChild('Worksheet');
	$worksheet->addAttribute('ss:Name', 'PO01071', $xmlns_ss);
	$worksheet->addAttribute('ss:Protected', '1', $xmlns_ss);

	//--------------------------------------------------------------------------------------------------------------------------------
	//Table
	//--------------------------------------------------------------------------------------------------------------------------------
	$table = $worksheet->addChild('Table');
	//https://www.roelvanlisdonk.nl/2009/02/09/remove-expandedcoluncount-and-expandedrowcount-when-using-exelxml-file-as-template/
	//ne met pas les Expanded car si ne correspond pas au nombre de ligne cela génère une erreur
	/*
	$table->addAttribute('ss:ExpandedColumnCount', '17', $xmlns_ss);
	$table->addAttribute('ss:ExpandedRowCount', '29', $xmlns_ss);
	$table->addAttribute('x:FullColumns', '1', $xmlns_x);
	$table->addAttribute('x:FullRows', '1', $xmlns_x);
	*/
	$table->addAttribute('ss:DefaultRowHeight', '14.4375', $xmlns_ss);

	$column = $table->addChild('Column');
	$column->addAttribute('ss:Width', '120', $xmlns_ss);
	$column = $table->addChild('Column');
	$column->addAttribute('ss:Width', '300', $xmlns_ss);
	$column = $table->addChild('Column');
	$column->addAttribute('ss:Width', '90', $xmlns_ss);
	//$column->addAttribute('ss:Span', '13', $xmlns_ss);
	$column = $table->addChild('Column');
	//$column->addAttribute('ss:Index', '17', $xmlns_ss);
	$column->addAttribute('ss:Width', '150', $xmlns_ss);
	$column = $table->addChild('Column');
	$column->addAttribute('ss:Width', '90', $xmlns_ss);
	$column = $table->addChild('Column');
	$column->addAttribute('ss:Width', '50', $xmlns_ss);
	$column = $table->addChild('Column');
	$column->addAttribute('ss:Width', '70', $xmlns_ss);
	$column = $table->addChild('Column');
	$column->addAttribute('ss:Width', '70', $xmlns_ss);
	$column = $table->addChild('Column');
	$column->addAttribute('ss:Width', '100', $xmlns_ss);
	$column = $table->addChild('Column');
	$column->addAttribute('ss:Width', '70', $xmlns_ss);
	$column = $table->addChild('Column');
	$column->addAttribute('ss:Width', '70', $xmlns_ss);

	//dd($resultat);
	$tableRow = array(
		'Order Reference*'=>array('value'=>$resultat[0]['CCT_REF_CMDE_CLI1'], 'style'=>'s63'),
		'Order Type'=>array('value'=>'Regular', 'style'=>'s63'),
		'Order Category'=>array('value'=>'Medical', 'style'=>'s63'),
		'Creation Date'=>array('value'=>$resultat[0]['MAX_CCT_DT_CMDE'], 'style'=>'s64'),
		'Supplier Reference'=>array('value'=>$resultat[0]['ALL_CCT_NO'], 'style'=>'s63'),
		'Details'=>array('value'=>'', 'style'=>'s63'),
		'Delivery Requested Date'=>array('value'=>$resultat[0]['MAX_CCT_DT_PREV_LIV'], 'style'=>'s64'),
		'Details'=>array('value'=>'', 'style'=>'s63'),
		'Stock Take Date'=>array('value'=>'', 'style'=>'s63'),
		'Transport mode'=>array('value'=>ucfirst(strtolower($resultat[0]['MTR_LIB'])), 'style'=>'s63'),
		'RTS Date'=>array('value'=>$resultat[0]['MAX_CCT_DT_FERM'], 'style'=>'s64'),
		/*'Address name'=>array('value'=>'', 'style'=>'s63'),
		'Address street'=>array('value'=>$resultat[0]['CCT_ADR1_DISP'], 'style'=>'s63'),
		'Address street 2'=>array('value'=>$resultat[0]['CCT_ADR23_DISP'], 'style'=>'s63'),
		'Zip'=>array('value'=>$resultat[0]['CCT_POSTAL_DISP'], 'style'=>'s63'),
		'City'=>array('value'=>$resultat[0]['CCT_VILLE_DISP'], 'style'=>'s63'),
		'Country'=>array('value'=>$resultat[0]['CCT_NOM_DISP'], 'style'=>'s63'),*/
		'Delivery address name'=>array('value'=>'', 'style'=>'s63'),
		'Delivery address'=>array('value'=>'', 'style'=>'s63'),
		'Customer address name'=>array('value'=>'', 'style'=>'s63'),
		'Customer address'=>array('value'=>'', 'style'=>'s63'),
		
		'Shipment Date'=>array('value'=>'', 'style'=>'s64'),
		'Notes'=>array('value'=>'', 'style'=>'s63'),
		'Origin'=>array('value'=>$resultat[0]['CCT_REF_CMDE_CLI2'], 'style'=>'s63'),
		'Project Ref.'=>array('value'=>'', 'style'=>'s63'),
		'Message ESC Header'=>array('value'=>'', 'style'=>'s63'),
		'Sourcing group'=>array('value'=>'', 'style'=>'s63'),
	);


	foreach($tableRow as $title=>$tabValue){
		$row = $table->addChild('Row');
		$row->addAttribute('ss:AutoFitHeight', '0', $xmlns_ss);

		$cell = $row->addChild('Cell');
		$cell->addAttribute('ss:StyleID', 's62', $xmlns_ss);

		$data = $cell->addChild('Data', $title, $xmlns);
		$data->addAttribute('ss:Type', 'String', $xmlns_ss);

		$cell = $row->addChild('Cell');
		$cell->addAttribute('ss:StyleID', $tabValue['style'], $xmlns_ss);

		$data = $cell->addChild('Data', $tabValue['value'], $xmlns);
		$data->addAttribute('ss:Type', 'String', $xmlns_ss);
	}


	$row = $table->addChild('Row');

	$cell = $row->addChild('Cell');
	$cell->addAttribute('ss:MergeDown', '1', $xmlns_ss);
	$cell->addAttribute('ss:StyleID', 'm44381952', $xmlns_ss);

	$data = $cell->addChild('Data', 'Analytic Distribution', $xmlns);
	$data->addAttribute('ss:Type', 'String', $xmlns_ss);

	$cell = $row->addChild('Cell');
	$cell->addAttribute('ss:StyleID', 's62', $xmlns_ss);

	$data = $cell->addChild('Data', 'Destination', $xmlns);
	$data->addAttribute('ss:Type', 'String', $xmlns_ss);

	$cell = $row->addChild('Cell');
	$cell->addAttribute('ss:StyleID', 's62', $xmlns_ss);

	$data = $cell->addChild('Data', 'Cost Center', $xmlns);
	$data->addAttribute('ss:Type', 'String', $xmlns_ss);

	$cell = $row->addChild('Cell');
	$cell->addAttribute('ss:StyleID', 's62', $xmlns_ss);

	$data = $cell->addChild('Data', '%', $xmlns);
	$data->addAttribute('ss:Type', 'String', $xmlns_ss);

	$cell = $row->addChild('Cell');
	$cell->addAttribute('ss:StyleID', 's62', $xmlns_ss);

	$data = $cell->addChild('Data', 'Subtotal', $xmlns);
	$data->addAttribute('ss:Type', 'String', $xmlns_ss);




	$row = $table->addChild('Row');
	$row->addAttribute('ss:Height', '28.8', $xmlns_ss);

	$cell = $row->addChild('Cell');
	$cell->addAttribute('ss:Index', '2', $xmlns_ss);
	$cell->addAttribute('ss:StyleID', 's63', $xmlns_ss);

	$data = $cell->addChild('Data', 'OPS', $xmlns);
	$data->addAttribute('ss:Type', 'String', $xmlns_ss);

	$cell = $row->addChild('Cell');
	$cell->addAttribute('ss:StyleID', 's63', $xmlns_ss);

	$data = $cell->addChild('Data', '', $xmlns);
	$data->addAttribute('ss:Type', 'String', $xmlns_ss);

	$cell = $row->addChild('Cell');
	$cell->addAttribute('ss:StyleID', 's63', $xmlns_ss);

	$data = $cell->addChild('Data', '', $xmlns);
	$data->addAttribute('ss:Type', 'String', $xmlns_ss);

	$cell = $row->addChild('Cell');
	$cell->addAttribute('ss:StyleID', 's63', $xmlns_ss);

	$data = $cell->addChild('Data', '', $xmlns);
	$data->addAttribute('ss:Type', 'String', $xmlns_ss);



	//les lignes
	$row = $table->addChild('Row');
	$row->addAttribute('ss:Height', '43.2', $xmlns_ss);

	$tableTitre = array('Line number'=>array('style'=>'s63','type'=>'String','field'=>'CCL_DES2'),
		'Ext. Ref.'=>array('style'=>'s63','type'=>'String','field'=>'OP_NO_LIGNE'),
		'Product Code*'=>array('style'=>'s63','type'=>'String','field'=>'CCL_ART_CODE'),
		'Product Description'=>array('style'=>'s63','type'=>'String','field'=>'DES1'),
		'Product Qty*'=>array('style'=>'s63','type'=>'Number','field'=>'SUM_QTE_CMDE'),
		'Product UoM*'=>array('style'=>'s63','type'=>'String','field'=>'PRODUCT_UOM'),
		'Price Unit*'=>array('style'=>'s63','type'=>'Number','field'=>'PRIX_UNITAIRE'),
		'Currency*'=>array('style'=>'s63','type'=>'String','field'=>'CCT_DEV_CODE'),
		'Origin*'=>array('style'=>'s63','type'=>'String','field'=>'CCT_REF_CMDE_CLI2'),
		'Stock Take Date'=>array('style'=>'s63','type'=>'String'),
	//'Delivery requested date'=>array('style'=>'s64','type'=>'DateTime','field'=>'MAX_CCT_DT_PREV_LIV'),
	//'Delivery confirmed date*'=>array('style'=>'s64','type'=>'DateTime','field'=>'MAX_DT_LIV_PREV'),
	//Avec DateTime il met la date en valeur unix
		'Delivery requested date'=>array('style'=>'s64','type'=>'String','field'=>'MAX_CCT_DT_PREV_LIV'),
		'Delivery confirmed date*'=>array('style'=>'s64','type'=>'String','field'=>'MAX_DT_LIV_PREV'),
		'Nomen Name'=>array('style'=>'s63','type'=>'String'),
		'Nomen Group'=>array('style'=>'s63','type'=>'String'),
		'Nomen Family'=>array('style'=>'s63','type'=>'String'),
		'Comment'=>array('style'=>'s63','type'=>'String'),
		'Notes'=>array('style'=>'s63','type'=>'String'),
		'Project Ref'=>array('style'=>'s63','type'=>'String'),
		'ESC Message 1'=>array('style'=>'s63','type'=>'String'),
		'ESC Message 2'=>array('style'=>'s63','type'=>'String'),
		'Destination'=>array('style'=>'s63','type'=>'String'),
		'Cost Center'=>array('style'=>'s63','type'=>'String'),
		'%'=>array('style'=>'s63','type'=>'String'),
		'Subtotal'=>array('style'=>'s63','type'=>'String')
	);
	

	foreach($tableTitre as $title=>$tabValue){
		$cell = $row->addChild('Cell');
		$cell->addAttribute('ss:StyleID', 's62', $xmlns_ss);

		$data = $cell->addChild('Data', $title, $xmlns);
		$data->addAttribute('ss:Type', 'String', $xmlns_ss);
	}


	foreach($resultat as $result){
		$row = $table->addChild('Row');
		$row->addAttribute('ss:Height', '86.4', $xmlns_ss);

		foreach($tableTitre as $title=>$tabValue){
			$cell = $row->addChild('Cell');
			$cell->addAttribute('ss:StyleID', $tabValue['style'], $xmlns_ss);

			if (isset($tabValue['field'])) {
				$field = $result[$tabValue['field']];
			} else {
				$field = "";
			}
			
			
	//Exception
			if($title == 'Ext. Ref.'){
				$field = "";
				if($result['CCL_DES2'] == ""){	
					$field = $result['OP_NO_LIGNE'];
				}
			}

			//$data = $cell->addChild('Data', ($tabValue['type'] == 'String'?utf8_encode($field):$field), $xmlns);
			$data = $cell->addChild('Data', ($tabValue['type'] == 'String'?htmlspecialchars(utf8_encode($field)):$field), $xmlns); 
			//$data = $cell->addChild('Data', ($tabValue['type'] == 'String'?iconv("UTF-8", "Windows-1252//TRANSLIT",$field):$field), $xmlns);
			$data->addAttribute('ss:Type', $tabValue['type'], $xmlns_ss);
		}
	}


	//--------------------------------------------------------------------------------------------------------------------------------
	//WorksheetOptions
	//--------------------------------------------------------------------------------------------------------------------------------
	$worksheetOptions = $worksheet->addChild('WorksheetOptions');
	$worksheetOptions->addAttribute('ss:xmlns', 'urn:schemas-microsoft-com:office:office', $xmlns);

	//$unsynced = $worksheetOptions->addChild('Unsynced', '', $xmlns);

	$selected = $worksheetOptions->addChild('Selected', '', $xmlns);

	//$topRowVisible = $worksheetOptions->addChild('TopRowVisible', '21', $xmlns);

	$panes = $worksheetOptions->addChild('Panes', '', $xmlns);
	$pane = $panes->addChild('Pane', '', $xmlns);
	$number = $panes->addChild('Number', '3', $xmlns);
	//$activeRow = $panes->addChild('ActiveRow', '1', $xmlns);
	$activeCol = $panes->addChild('ActiveCol', '1', $xmlns);

	$protectObjects = $worksheetOptions->addChild('ProtectObjects', 'True', $xmlns);
	$protectScenarios = $worksheetOptions->addChild('ProtectScenarios', 'True', $xmlns);
	$enableSelection = $worksheetOptions->addChild('EnableSelection', 'UnlockedCells', $xmlns);
	$allowInsertRows = $worksheetOptions->addChild('AllowInsertRows', '', $xmlns);


	//Pour indenter le XML
	$dom = dom_import_simplexml($Workbook)->ownerDocument;
	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;
	//echo $Workbook->asXml();

	//OCILogoff($c);
	
	return($dom->saveXML());

	//$fileXml = fopen("/tmp/".$filename.".xml", "w+");
	//$Workbook->asXml("/tmp/test.xml");
	//$dom->save("/tmp/".$filename.".xml");				

}

//echo get_xml_for_unifield('18/BE/ZW101/PO03036');
//echo get_xml_spreadsheet_for_unifield('18/BE/ZW101/PO03036');

?>