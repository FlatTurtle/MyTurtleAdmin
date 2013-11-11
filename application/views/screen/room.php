<div class='row submenu'>
    <div class='span3'>
        
                <ul class="pager backlink">
                    <li class="previous">
                        <?php
                            $link = $infoscreen->alias;
                            if(isset($back_link)){
                                $link = $back_link;
                            }
                        ?>
                        <a href="<?= site_url($link); ?>/reservations">&larr; Back</a>
                    </li>
                </ul>
    </div>
    <? if($edit){?>
    <div class="span9">
        <a href="#" class="btn pull-right"><i class="icon-save"></i>  Save</a>
    </div>
    <?}else{?>
        <a href="#" class="btn pull-right"><i class="icon-remove"></i> Delete room</a>
                <a href="<?= site_url($infoscreen->alias)?>/reservations/rooms/<?= $room->name ?>/edit" class="btn pull-right"><i class="icon-edit"></i> Edit room</a>

    <?}?>
</div>
    <div class="row">
	<div class='span10 offset2'>
    <? if($edit){?>

        <h3><input id="name" name="name" type="text" value="<?= $room->name?>"  class="span9 input-xlarge"></h3>
        <br />
        
        <!-- description input-->
        <div class="control-group">
            <label class="control-label">Description</label>
            <div class="controls">
                <textarea rows="3" id="description" name="description" class="input-block-level" ><?= $room->description ?></textarea>
                <p class="help-block"></p>
            </div>
        </div>

        <h4>Location</h4>

         <div class="control-group ">
                <label class="control-label" for="inputMap">Map</label>
                <div class="controls">
                    <input type="file" id="inputMap" name="map" class="hide better-file-upload"/>
                    <div class="input-append">
                       <input id="inputMapVal" class="input-large file-value" type="text">
                       <a class="btn file-button">Browse</a>
                    </div>
                </div>
            </div>


        <div class="control-group">
            <label class="control-label">Floor</label>
            <div class="controls">
                <select class="span2" selected="<?= $room->location->floor ?>" 
                    value="<?= $room->location->floor ?>"name="location_floor">
                <option value="-3">-3</option>
                <option value="-2">-2</option>
                <option value="-1">-1</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                </select>
                <p class="help-block"></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Building name</label>
            <div class="controls">
                <input id="location_building_name" value="<?= $room->location->map->reference ?>"name="location_building_name" type="text" placeholder="Building's name"
                class="input-xlarge">
                <p class="help-block"></p>
            </div>
        </div>

        <h4>Price rates 
        <small>
        <a class="btn btn-lg btn-success btn-block pull-right span2" type="submit" onClick="addPriceRate(); return false;" id="addPriceRate" name="addPriceRate">Add price rate</a>
        </small>
        </h4> 

        
        <div id="priceRates">
        </div>
        
        

        <h4>Amenities</h4>
        <div class="control-group">
        <div class="controls">
        <? if(isset($room->amenities)){foreach($room->amenities as $amenity){?>
             <div class="checkbox">
            <label>
                <input type="checkbox"> <?= $amenity->name ?>
            </label>
        </div>
        <?}}?>
        </div>
        </div>

        <h4>Contact</h4>
        <div class="control-group">
            <label class="control-label">Contact</label>
            <div class="controls">
                <input id="buildign_name" value="<?= $room->contact ?>" name="contact" type="text"
                class="input-xlarge">
                <p class="help-block"></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Support</label>
            <div class="controls">
                <input id="buildign_name" value="<?= $room->support ?>" name="support" type="text"
                class="input-xlarge">
                <p class="help-block"></p>
            </div>
        </div>

        <h4>Opening hours
        <small>
            <a class="btn btn-lg btn-success btn-block pull-right span2" type="submit" onClick="addOpeningHours(); return false;" id="addOpeningHours" name="addOpeningHours">Add opening hours</a>
            </small>
        </h4>

        <div class="control-group">
            <label class="control-label">Valid from</label>
            <div class="controls">
                <div class="input-append date datepicker" id="validFromDP" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                    <input class="span2" size="16" name="validFrom" id="validFrom" type="text" value="12-02-2012">
                    <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Valid through</label>
            <div class="controls">
                <div class="input-append date datepicker" id="validThroughDP" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                    <input class="span2" size="16" name="validFrom" id="validThrough" type="text" value="12-02-2012">
                    <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
            </div>
        </div>

        <div id="openingHours">
        </div>


    <?}else{?>
    <h3>
        <?= $room->name ?>
        
        
    </h3>
    <p>Description : <?= $room->description ?></p>
        <p>Contact : <a href="<?= $room->contact?>" alt="contact"><?= $room->contact?></a></p>
        <p>Support : <a href="<?= $room->support?>" alt="support"><?= $room->support?></a></p>

        <h4>Opening hours </h4>

            <table>
            <tr>
            <? foreach($room->opening_hours as $opening_hour){?>
                <td><? echo date('D', $opening_hour->dayOfWeek); ?></td>
            <?}?>
            </tr>
            </table>
        <h4>Price rates</h4>

            <? foreach(get_object_vars($room->price) as $var){ ?>
                <p><?=$var?> </p>
            <?}?>
        <h4>Location</h4>
            <p>Img : <?= $room->location->map->img ?></p>
            <p>Floor : <?= $room->location->floor ?></p>
            <p>Reference : <?= $room->location->map->reference ?></p>

        <h4>Amenities</h4>

	</div>
    <?}?>
</div>
<link rel="stylesheet" href="<?= base_url()?>/assets/css/datepicker.css" type="text/css" media="screen" />
<script src='<?= base_url()?>/assets/js/bootstrap-datepicker.js' type='text/javascript'></script>

<script type="text/javascript">
    $('.datepicker').datepicker();

    var price_rate_index = 0;
    var opening_hours_index = 0;

    var addPriceRate = function() {

        
        var content =  ' \
        <div id="priceRate_'+price_rate_index+'" class="form-group"> \
            <div class="control-group"> \
                <div class="controls"> \
                    <label class="control-label span1">Currency</label> \
                    <select class="span1" name="currency_'+price_rate_index+'"> \
                        <option value="AFA">Afghani</option><option value="AFN">Afghani</option><option value="ALK">Albanian old lek</option><option value="ALL">Lek</option><option value="DZD">Algerian Dinar</option><option value="USD">US Dollar</option><option value="ADF">Andorran Franc</option><option value="ADP">Andorran Peseta</option><option value="EUR">Euro</option><option value="AOR">Angolan Kwanza Readjustado</option><option value="AON">Angolan New Kwanza</option><option value="AOA">Kwanza</option><option value="XCD">East Caribbean Dollar</option><option value="ARA">Argentine austral</option><option value="ARS">Argentine Peso</option><option value="ARL">Argentine peso ley</option><option value="ARM">Argentine peso moneda nacional</option><option value="ARP">Peso argentino</option><option value="AMD">Armenian Dram</option><option value="AWG">Aruban Guilder</option><option value="AUD">Australian Dollar</option><option value="ATS">Austrian Schilling</option><option value="AZM">Azerbaijani manat</option><option value="AZN">Azerbaijanian Manat</option><option value="BSD">Bahamian Dollar</option><option value="BHD">Bahraini Dinar</option><option value="BDT">Taka</option><option value="BBD">Barbados Dollar</option><option value="BYR">Belarussian Ruble</option><option value="BEC">Belgian Franc (convertible)</option><option value="BEF">Belgian Franc (currency union with LUF)</option><option value="BEL">Belgian Franc (financial)</option><option value="BZD">Belize Dollar</option><option value="XOF">CFA Franc BCEAO</option><option value="BMD">Bermudian Dollar</option><option value="INR">Indian Rupee</option><option value="BTN">Ngultrum</option><option value="BOP">Bolivian peso</option><option value="BOB">Boliviano</option><option value="BOV">Mvdol</option><option value="BAM">Convertible Marks</option><option value="BWP">Pula</option><option value="NOK">Norwegian Krone</option><option value="BRC">Brazilian cruzado</option><option value="BRB">Brazilian cruzeiro</option><option value="BRL">Brazilian Real</option><option value="BND">Brunei Dollar</option><option value="BGN">Bulgarian Lev</option><option value="BGJ">Bulgarian lev A/52</option><option value="BGK">Bulgarian lev A/62</option><option value="BGL">Bulgarian lev A/99</option><option value="BIF">Burundi Franc</option><option value="KHR">Riel</option><option value="XAF">CFA Franc BEAC</option><option value="CAD">Canadian Dollar</option><option value="CVE">Cape Verde Escudo</option><option value="KYD">Cayman Islands Dollar</option><option value="CLP">Chilean Peso</option><option value="CLF">Unidades de fomento</option><option value="CNX">Chinese People\'s Bank dollar</option><option value="CNY">Yuan Renminbi</option><option value="COP">Colombian Peso</option><option value="COU">Unidad de Valor real</option><option value="KMF">Comoro Franc</option><option value="CDF">Franc Congolais</option><option value="NZD">New Zealand Dollar</option><option value="CRC">Costa Rican Colon</option><option value="HRK">Croatian Kuna</option><option value="CUP">Cuban Peso</option><option value="CYP">Cyprus Pound</option><option value="CZK">Czech Koruna</option><option value="CSK">Czechoslovak koruna</option><option value="CSJ">Czechoslovak koruna A/53</option><option value="DKK">Danish Krone</option><option value="DJF">Djibouti Franc</option><option value="DOP">Dominican Peso</option><option value="ECS">Ecuador sucre</option><option value="EGP">Egyptian Pound</option><option value="SVC">Salvadoran colón</option><option value="EQE">Equatorial Guinean ekwele</option><option value="ERN">Nakfa</option><option value="EEK">Kroon</option><option value="ETB">Ethiopian Birr</option><option value="FKP">Falkland Island Pound</option><option value="FJD">Fiji Dollar</option><option value="FIM">Finnish Markka</option><option value="FRF">French Franc</option><option value="XFO">Gold-Franc</option><option value="XPF">CFP Franc</option><option value="GMD">Dalasi</option><option value="GEL">Lari</option><option value="DDM">East German Mark of the GDR (East Germany)</option><option value="DEM">Deutsche Mark</option><option value="GHS">Ghana Cedi</option><option value="GHC">Ghanaian cedi</option><option value="GIP">Gibraltar Pound</option><option value="GRD">Greek Drachma</option><option value="GTQ">Quetzal</option><option value="GNF">Guinea Franc</option><option value="GNE">Guinean syli</option><option value="GWP">Guinea-Bissau Peso</option><option value="GYD">Guyana Dollar</option><option value="HTG">Gourde</option><option value="HNL">Lempira</option><option value="HKD">Hong Kong Dollar</option><option value="HUF">Forint</option><option value="ISK">Iceland Krona</option><option value="ISJ">Icelandic old krona</option><option value="IDR">Rupiah</option><option value="IRR">Iranian Rial</option><option value="IQD">Iraqi Dinar</option><option value="IEP">Irish Pound (Punt in Irish language)</option><option value="ILP">Israeli lira</option><option value="ILR">Israeli old sheqel</option><option value="ILS">New Israeli Sheqel</option><option value="ITL">Italian Lira</option><option value="JMD">Jamaican Dollar</option><option value="JPY">Yen</option><option value="JOD">Jordanian Dinar</option><option value="KZT">Tenge</option><option value="KES">Kenyan Shilling</option><option value="KPW">North Korean Won</option><option value="KRW">Won</option><option value="KWD">Kuwaiti Dinar</option><option value="KGS">Som</option><option value="LAK">Kip</option><option value="LAJ">Lao kip</option><option value="LVL">Latvian Lats</option><option value="LBP">Lebanese Pound</option><option value="LSL">Loti</option><option value="ZAR">Rand</option><option value="LRD">Liberian Dollar</option><option value="LYD">Libyan Dinar</option><option value="CHF">Swiss Franc</option><option value="LTL">Lithuanian Litas</option><option value="LUF">Luxembourg Franc (currency union with BEF)</option><option value="MOP">Pataca</option><option value="MKD">Denar</option><option value="MKN">Former Yugoslav Republic of Macedonia denar A/93</option><option value="MGA">Malagasy Ariary</option><option value="MGF">Malagasy franc</option><option value="MWK">Kwacha</option><option value="MYR">Malaysian Ringgit</option><option value="MVQ">Maldive rupee</option><option value="MVR">Rufiyaa</option><option value="MAF">Mali franc</option><option value="MTL">Maltese Lira</option><option value="MRO">Ouguiya</option><option value="MUR">Mauritius Rupee</option><option value="MXN">Mexican Peso</option><option value="MXP">Mexican peso</option><option value="MXV">Mexican Unidad de Inversion (UDI)</option><option value="MDL">Moldovan Leu</option><option value="MCF">Monegasque franc (currency union with FRF)</option><option value="MNT">Tugrik</option><option value="MAD">Moroccan Dirham</option><option value="MZN">Metical</option><option value="MZM">Mozambican metical</option><option value="MMK">Kyat</option><option value="NAD">Namibia Dollar</option><option value="NPR">Nepalese Rupee</option><option value="NLG">Netherlands Guilder</option><option value="ANG">Netherlands Antillian Guilder</option><option value="NIO">Cordoba Oro</option><option value="NGN">Naira</option><option value="OMR">Rial Omani</option><option value="PKR">Pakistan Rupee</option><option value="PAB">Balboa</option><option value="PGK">Kina</option><option value="PYG">Guarani</option><option value="YDD">South Yemeni dinar</option><option value="PEN">Nuevo Sol</option><option value="PEI">Peruvian inti</option><option value="PEH">Peruvian sol</option><option value="PHP">Philippine Peso</option><option value="PLZ">Polish zloty A/94</option><option value="PLN">Zloty</option><option value="PTE">Portuguese Escudo</option><option value="TPE">Portuguese Timorese escudo</option><option value="QAR">Qatari Rial</option><option value="RON">New Leu</option><option value="ROL">Romanian leu A/05</option><option value="ROK">Romanian leu A/52</option><option value="RUB">Russian Ruble</option><option value="RWF">Rwanda Franc</option><option value="SHP">Saint Helena Pound</option><option value="WST">Tala</option><option value="STD">Dobra</option><option value="SAR">Saudi Riyal</option><option value="RSD">Serbian Dinar</option><option value="CSD">Serbian Dinar</option><option value="SCR">Seychelles Rupee</option><option value="SLL">Leone</option><option value="SGD">Singapore Dollar</option><option value="SKK">Slovak Koruna</option><option value="SIT">Slovenian Tolar</option><option value="SBD">Solomon Islands Dollar</option><option value="SOS">Somali Shilling</option><option value="ZAL">South African financial rand (Funds code) (discont</option><option value="ESP">Spanish Peseta</option><option value="ESA">Spanish peseta (account A)</option><option value="ESB">Spanish peseta (account B)</option><option value="LKR">Sri Lanka Rupee</option><option value="SDD">Sudanese Dinar</option><option value="SDP">Sudanese Pound</option><option value="SDG">Sudanese Pound</option><option value="SRD">Surinam Dollar</option><option value="SRG">Suriname guilder</option><option value="SZL">Lilangeni</option><option value="SEK">Swedish Krona</option><option value="CHE">WIR Euro</option><option value="CHW">WIR Franc</option><option value="SYP">Syrian Pound</option><option value="TWD">New Taiwan Dollar</option><option value="TJS">Somoni</option><option value="TJR">Tajikistan ruble</option><option value="TZS">Tanzanian Shilling</option><option value="THB">Baht</option><option value="TOP">Pa\'anga</option><option value="TTD">Trinidata and Tobago Dollar</option><option value="TND">Tunisian Dinar</option><option value="TRY">New Turkish Lira</option><option value="TRL">Turkish lira A/05</option><option value="TMM">Manat</option><option value="RUR">Russian rubleA/97</option><option value="SUR">Soviet Union ruble</option><option value="UGX">Uganda Shilling</option><option value="UGS">Ugandan shilling A/87</option><option value="UAH">Hryvnia</option><option value="UAK">Ukrainian karbovanets</option><option value="AED">UAE Dirham</option><option value="GBP">Pound Sterling</option><option value="USN">US Dollar (Next Day)</option><option value="USS">US Dollar (Same Day)</option><option value="UYU">Peso Uruguayo</option><option value="UYN">Uruguay old peso</option><option value="UYI">Uruguay Peso en Unidades Indexadas</option><option value="UZS">Uzbekistan Sum</option><option value="VUV">Vatu</option><option value="VEF">Bolivar Fuerte</option><option value="VEB">Venezuelan Bolivar</option><option value="VND">Dong</option><option value="VNC">Vietnamese old dong</option><option value="YER">Yemeni Rial</option><option value="YUD">Yugoslav Dinar</option><option value="YUM">Yugoslav dinar (new)</option><option value="ZRN">Zairean New Zaire</option><option value="ZRZ">Zairean Zaire</option><option value="ZMK">Kwacha</option><option value="ZWD">Zimbabwe Dollar</option><option value="ZWC">Zimbabwe Rhodesian dollar</option> \
                    </select> \
                    <label class="span1" class="control-label">Timing</label> \
                    <select class="span1" id="timing_'+price_rate_index+'" name="timing_'+price_rate_index+'"> \
                        <option value="hourly">Hourly</option> \
                        <option value="daily">Daily</option> \
                        <option value="weekly">Weekly</option> \
                        <option value="monthly">Monthly</option> \
                        <option value="yearly">Yearly</option> \
                    </select> \
                    <label class="control-label span1">Amount</label> \
                    <input class="span1" id="amount_'+price_rate_index+'" name="amount_'+price_rate_index+'" type="text" placeholder="Amount" class="input-xlarge"> \
                <a class="btn btn-lg btn-error btn-block" type="submit" onClick="removePriceRate('+price_rate_index+'); return false;" id="removePriceRate" name="removePriceRate">X</a> \
                </div> \
            </div> \
        </div>';
        $(content).animate({ opacity: "show" }, "slow").appendTo('#priceRates');
        price_rate_index++; 
    }

    var removePriceRate = function(index) {

        $('#priceRate_'+index).remove();
        price_rate_index--;
    }

    /**
     * Add an input field to add opening hours on a specific day 
     * TODO(qkaiser) : find a way to let a user select multiple time slots for the same day // maybe http://jdewit.github.io/bootstrap-timepicker/
     */
    var addOpeningHours = function() {
        var content =  ' \
        <div id="openingHour_'+opening_hours_index+'" class="form-group"> \
            <div class="control-group"> \
                <div class="controls"> \
                    <label class="span1" class="control-label">Day</label> \
                    <select class="span1" id="timing_'+opening_hours_index+'" name="day_'+opening_hours_index+'"> \
                        <option value="1">Monday</option> \
                        <option value="2">Tuesday</option> \
                        <option value="3">Wednesday</option> \
                        <option value="4">Thursday</option> \
                        <option value="5">Friday</option> \
                        <option value="6">Saturday</option> \
                        <option value="7">Sunday</option> \
                    </select> \
                <a class="btn btn-lg btn-error btn-block" type="submit" onClick="removeOpeningHours('+opening_hours_index+'); return false;" id="removePriceRate" name="removePriceRate">X</a> \
                </div> \
            </div> \
        </div>';
        $(content).animate({ opacity: "show" }, "slow").appendTo('#openingHours');
        opening_hours_index++;
    }


    /**
     * Remove the opening hour div with index index
     */
    var removeOpeningHours = function(index) {
        $('#openingHour_'+index).remove();
        opening_hours_index--;
    }

    /*
        $(".checkbox").change(function() {
            if(this.checked) {
                //Do stuff
            }
        });
    */
    /**
     * When the user check an amenity checkboxes we add a custom form with the values the user needs to fill for this specific amenity
     */
    var addAmenity = function() {
        return false;
    }

    /**
     * Remove the amenity with index index when the user uncheck its checkbox
     */
    var removeAmenity = function(index) {
        return false;
    }
</script>


		