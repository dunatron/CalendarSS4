<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2/02/17
 * Time: 1:55 PM
 */

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\LiteralField;


class EventFindaExtension extends DataExtension
{
    private static $db = array(
        'BaseQuery' => 'Varchar(255)',
        'LocationQuery' => 'Varchar(255)'
    );

    private static $has_one = array();

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab("Root.EventFindaConfig",
            new TextField("BaseQuery", 'e.g. http://api.eventfinda.co.nz/v2/events.json?rows=20&session:(timezone,datetime_start)&order=popularity')
        );
        $fields->addFieldToTab("Root.EventFindaConfig",
            new TextField("LocationQuery", 'e.g. &location=126')
        );
        $fields->addFieldToTab("Root.EventFindaConfig",
            new ReadonlyField("ListofRegions", 'e.g. &location=126')
        );


        $locations = LiteralField::create(
            'AccessType',
            '
         <ul class="list-group">
    <ul class="list-group">
    <li style="color:red;">Northland->1</li>
    <ul>
      <li style="color:green; padding-left:15px;">Bay of Islands->6648</li>
      <li style="color:green; padding-left:15px;">Far North->22</li>
      <li style="color:green; padding-left:15px;">Kaipara->6649</li>
      <li style="color:green; padding-left:15px;">Mid North->11068</li>
      <li style="color:green; padding-left:15px;">Whangarei District->27</li>
    </ul>
    <li style="color:red;">Auckland->2</li>
    <ul>
      <li style="color:green; padding-left:15px;">Auckland Central->28</li>
      <li style="color:green; padding-left:15px;">Auckland East->1382</li>
      <li style="color:green; padding-left:15px;">Auckland Nort->1381</li>
      <li style="color:green; padding-left:15px;">Auckland South->1383</li>
      <li style="color:green; padding-left:15px;">Auckland West->1384</li>
      <li style="color:green; padding-left:15px;">Gulf Islands->7093</li>
    </ul>
    <li style="color:red;">The Coromandel->41</li>
    <ul>
      <li style="color:green; padding-left:15px;">Colville->656</li>
      <li style="color:green; padding-left:15px;">Cooks Beach->807</li>
      <li style="color:green; padding-left:15px;">Coroglen->7776</li>
      <li style="color:green; padding-left:15px;">Coromandel->652</li>
      <li style="color:green; padding-left:15px;">Hahei->773</li>
      <li style="color:green; padding-left:15px;">Hot Water Beach->1876</li>
      <li style="color:green; padding-left:15px;">Kauaeranga->7826</li>
      <li style="color:green; padding-left:15px;">Kennedy Bay->7760</li>
      <li style="color:green; padding-left:15px;">Kuaotunu->3407</li>
      <li style="color:green; padding-left:15px;">Matarangi->658</li>
      <li style="color:green; padding-left:15px;">Opito->809</li>
      <li style="color:green; padding-left:15px;">Opoutere->1789</li>
      <li style="color:green; padding-left:15px;">Otama->7761</li>
      <li style="color:green; padding-left:15px;">Pauanui->655</li>
      <li style="color:green; padding-left:15px;">Port Charles->3028</li>
      <li style="color:green; padding-left:15px;">Port Jackson->7756</li>
      <li style="color:green; padding-left:15px;">Tairua->654</li>
      <li style="color:green; padding-left:15px;">Tapu->810</li>
      <li style="color:green; padding-left:15px;">Te Puru->811</li>
      <li style="color:green; padding-left:15px;">Thames->51</li>
      <li style="color:green; padding-left:15px;">Waihi->28</li>
      <li style="color:green; padding-left:15px;">Waihi->53</li>
      <li style="color:green; padding-left:15px;">Waikino->789</li>
      <li style="color:green; padding-left:15px;">Whangamata->54</li>
      <li style="color:green; padding-left:15px;">Whangapoua->784</li>
      <li style="color:green; padding-left:15px;">Whitianga->572</li>
    </ul>
    <li style="color:red;">Hawkes Bay/Gisborne->6</li>
    <ul>
      <li style="color:green; padding-left:15px;">Central Hawke\'s Bay->7068</li>
      <li style="color:green; padding-left:15px;">East Cape->7067</li>
      <li style="color:green; padding-left:15px;">Gisborne->63</li>
      <li style="color:green; padding-left:15px;">Hastings->66</li>
      <li style="color:green; padding-left:15px;">Havelock North->568</li>
      <li style="color:green; padding-left:15px;">Napier->67</li>
      <li style="color:green; padding-left:15px;">Wairoa->69</li>
    </ul>
    <li style="color:red;">Waikato->3</li>
    <ul>
      <li style="color:green; padding-left:15px;">Hamilton->42</li>
      <li style="color:green; padding-left:15px;">Hauraki->7551</li>
      <li style="color:green; padding-left:15px;">Kawhia Harbour->5670</li>
      <li style="color:green; padding-left:15px;">Lake Taupo->7396</li>
      <li style="color:green; padding-left:15px;">Matamata-Piako->7389</li>
      <li style="color:green; padding-left:15px;">North Waikato->7387</li>
      <li style="color:green; padding-left:15px;">Otorohanga->46</li>
      <li style="color:green; padding-left:15px;">South Waikato->7395</li>
      <li style="color:green; padding-left:15px;">Waipa->797</li>
      <li style="color:green; padding-left:15px;">Waitomo District->804</li>
      <li style="color:green; padding-left:15px;">Wairoa->69</li>
    </ul>
    <li style="color:red;">Bay of Plenty->4</li>
    <ul>
      <li style="color:green; padding-left:15px;">Katikati->55</li>
      <li style="color:green; padding-left:15px;">Kawerau->762</li>
      <li style="color:green; padding-left:15px;">Matata->22303</li>
      <li style="color:green; padding-left:15px;">Mt Maunganui->571</li>
      <li style="color:green; padding-left:15px;">Opotiki->56</li>
      <li style="color:green; padding-left:15px;">Rotorua->57</li>
      <li style="color:green; padding-left:15px;">Taneatua->22976</li>
      <li style="color:green; padding-left:15px;">Tauranga->59</li>
      <li style="color:green; padding-left:15px;">Te Puke->60</li>
      <li style="color:green; padding-left:15px;">Waihi Beac->813</li>
      <li style="color:green; padding-left:15px;">Whakatane->62</li>
    </ul>
    <li style="color:red;">Taranaki->7</li>
    <ul>
      <li style="color:green; padding-left:15px;">New Plymouth->72</li>
      <li style="color:green; padding-left:15px;">North Taranaki->7751</li>
      <li style="color:green; padding-left:15px;">South Taranaki->7753</li>
      <li style="color:green; padding-left:15px;">Stratford->74</li>
    </ul>
    <li style="color:red;">Manawatu / Whanganui->9</li>
    <ul>
      <li style="color:green; padding-left:15px;">Ashhurst->7587</li>
      <li style="color:green; padding-left:15px;">Feilding and District->744</li>
      <li style="color:green; padding-left:15px;">Horowhenua->727</li>
      <li style="color:green; padding-left:15px;">Palmerston North->83</li>
      <li style="color:green; padding-left:15px;">Rangitikei->8</li>
      <li style="color:green; padding-left:15px;">Tararua->739</li>
      <li style="color:green; padding-left:15px;">Taumarunui->48</li>
      <li style="color:green; padding-left:15px;">Tongariro->7534</li>
      <li style="color:green; padding-left:15px;">Whanganui->78</li>
      <li style="color:green; padding-left:15px;">Whanganui River->7535</li>
    </ul>
    <li style="color:red;">Wellington Region->11</li>
    <ul>
      <li style="color:green; padding-left:15px;">Kapiti Coast->91</li>
      <li style="color:green; padding-left:15px;">Lower Hutt->92</li>
      <li style="color:green; padding-left:15px;">Porirua - Mana->93</li>
      <li style="color:green; padding-left:15px;">Upper Hutt->94</li>
      <li style="color:green; padding-left:15px;">Wairarapa->7138</li>
      <li style="color:green; padding-left:15px;">Wellington->363</li>
    </ul>
    <li style="color:red;">Nelson / Tasman->12</li>
    <ul>
      <li style="color:green; padding-left:15px;">Golden Bay->96</li>
      <li style="color:green; padding-left:15px;">Motueka->97</li>
      <li style="color:green; padding-left:15px;">Murchison->18291</li>
      <li style="color:green; padding-left:15px;">Nelson->99</li>
      <li style="color:green; padding-left:15px;">Nelson Lakes->98</li>
      <li style="color:green; padding-left:15px;">Tasman Bay->24591</li>
      <li style="color:green; padding-left:15px;">Upper Moutere->9859</li>
      <li style="color:green; padding-left:15px;">Waimea->1470</li>
    </ul>
    <li style="color:red;">Marlborough->13</li>
    <ul>
      <li style="color:green; padding-left:15px;">Blenheim->101</li>
      <li style="color:green; padding-left:15px;">Havelock->18122</li>
      <li style="color:green; padding-left:15px;">Marlborough Sounds->102</li>
      <li style="color:green; padding-left:15px;">Picton->18120</li>
      <li style="color:green; padding-left:15px;">Rai Valley->18125</li>
      <li style="color:green; padding-left:15px;">Renwick->18121</li>
      <li style="color:green; padding-left:15px;">Seddon->18123</li>
      <li style="color:green; padding-left:15px;">Wairau Valley->18124</li>
      <li style="color:green; padding-left:15px;">Ward->21403</li>
    </ul>
    <li style="color:red;">West Coast->14</li>
    <ul>
     <li style="color:green; padding-left:15px;">Buller->8074</li>
     <li style="color:green; padding-left:15px;">Grey->8075</li>
     <li style="color:green; padding-left:15px;">Westland->8076</li>
    </ul>
    <li style="color:red;">Canterbury->15</li>
    <ul>
     <li style="color:green; padding-left:15px;">Ashburton District->108</li>
     <li style="color:green; padding-left:15px;">Chatham Islands->805</li>
     <li style="color:green; padding-left:15px;">Christchurch District->8212</li>
     <li style="color:green; padding-left:15px;">Hurunui->660</li>
     <li style="color:green; padding-left:15px;">Kaikoura->115</li>
     <li style="color:green; padding-left:15px;">Mackenzie->694</li>
     <li style="color:green; padding-left:15px;">Selwyn->674</li>
     <li style="color:green; padding-left:15px;">South Canterbury->8138</li>
     <li style="color:green; padding-left:15px;">Waimakariri->701</li>
     <li style="color:green; padding-left:15px;">Waimate District->122</li>
     <li style="color:green; padding-left:15px;">Waitaki->8144</li>
    </ul>
    <li style="color:red;">Otago->17</li>
    <ul>
     <li style="color:green; padding-left:15px;">Central Otago->8425</li>
     <li style="color:green; padding-left:15px;">Dunedin->126</li>
     <li style="color:green; padding-left:15px;">North Otago->8422</li>
     <li style="color:green; padding-left:15px;">Queenstown Lakes->8426</li>
     <li style="color:green; padding-left:15px;">South Otago->8424</li>
    </ul>
    <li style="color:red;">Southland->18</li>
    <ul>
     <li style="color:green; padding-left:15px;">Bluff->19513</li>
     <li style="color:green; padding-left:15px;">Fiordland->5665</li>
     <li style="color:green; padding-left:15px;">Gore->136</li>
     <li style="color:green; padding-left:15px;">Invercargill->137</li>
     <li style="color:green; padding-left:15px;">Southland District->8329</li>
     <li style="color:green; padding-left:15px;">Stewart Island->141</li>
    </ul>
  </ul>
            '
        );


        $fields->addFieldToTab("Root.EventFindaConfig", $locations);

    }
}