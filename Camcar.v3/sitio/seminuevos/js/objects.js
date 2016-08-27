var domEl, tempsNames, urlsApi;
domEl = {
	"_detail_sen_element":".detail-sen-element",
	"btn_detail_sen_send":"#detail-sen-send",
	"btn_sen_get_search":"#sen-get-search",
	"div_get_models":"div#div-get-models",
	"div_map_canvas_detalle":"div#map-canvas-detalle",
	"div_recurrent":"div#content-temporal-interactive",
	"form_detail_sen_contact":"form#detail-sen-contact",
	"input_master_inventarios":"input#master-inventarios",
	"input_master_seminuevos":"input#master-seminuevos",
	"input_sen_get_searching":"input#sen-get-searching",
	"select_sen_get_brand":"select#sen-get-brand",
	"select_sen_get_model":"select#sen-get-model"
};
tempsNames = {
	"detalle_map_empty":"detalle_map_empty",
	"detalle_map_infobox":"detalle_map_infobox",
	"seminuevos_action_bar_modelos":"seminuevos_action_bar_modelos"
};
urlsApi = {
	"add_cnt":"api/v1/add/contactos/",
	"get_mdo":"api/v1/get/modelos/",
	"snd_cnt":"api/v1/send/contactos"
};
