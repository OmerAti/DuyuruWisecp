<?php 
/**
 * DuyuruWisecp - Wisecp Reklam Duyuru Modülü
 *
 * Yazar: Ömer ATABER - OmerAti JRodix.Com Internet Hizmetleri
 * Versiyon: 1.0.0
 * Tarih: 25.08.2024
 * Web: https://www.jrodix.com
 *
 */
class DuyuruWisecp extends AddonModule {
    public $version = "1.0";
    
    function __construct(){
        $this->_name = __CLASS__;
        parent::__construct();
    }
    
    public function fields(){
        $settings = isset($this->config['settings']) ? $this->config['settings'] : [];
        return [
            'DuyuruWisecp_ust'          => [
                'wrap_width'        => 100,
                'name'              => $this->lang["DuyuruWisecp_ust_name"],
                'description'       => $this->lang["DuyuruWisecp_ust_description"],
                'type'              => "text",
                'value'             => isset($settings["DuyuruWisecp_ust"]) ? $settings["DuyuruWisecp_ust"] : "",
                'placeholder'       => "Kampanya",
            ],
            'DuyuruWisecp_resim'          => [
                'wrap_width'        => 100,
                'name'              => $this->lang["DuyuruWisecp_resim_name"],
                'description'       => $this->lang["DuyuruWisecp_resim_description"],
                'type'              => "text",
                'value'             => isset($settings["DuyuruWisecp_resim"]) ? $settings["DuyuruWisecp_resim"] : "",
                'placeholder'       => "https://image.com/exampleimage.png",
            ],
            'DuyuruWisecp_metin'          => [
                'wrap_width'        => 100,
                'name'              => $this->lang["DuyuruWisecp_metin_name"],
                'description'       => $this->lang["DuyuruWisecp_metin_description"],
                'type'              => "text",
                'value'             => isset($settings["DuyuruWisecp_metin"]) ? $settings["DuyuruWisecp_metin"] : "",
                'placeholder'       => "Tüm Hosting Paketlerinde",
            ],
			'DuyuruWisecp_oran'          => [
                'wrap_width'        => 100,
                'name'              => $this->lang["DuyuruWisecp_oran_name"],
                'description'       => $this->lang["DuyuruWisecp_oran_description"],
                'type'              => "text",
                'value'             => isset($settings["DuyuruWisecp_oran"]) ? $settings["DuyuruWisecp_oran"] : "",
                'placeholder'       => "%20",
            ],
            'DuyuruWisecp_button'          => [
                'wrap_width'        => 100,
                'name'              => $this->lang["DuyuruWisecp_button_name"],
                'description'       => $this->lang["DuyuruWisecp_button_description"],
                'type'              => "text",
                'value'             => isset($settings["DuyuruWisecp_button"]) ? $settings["DuyuruWisecp_button"] : "",
                'placeholder'       => "https://example.com",
            ],
			'DuyuruWisecp_button_renk'          => [
                'wrap_width'        => 100,
                'name'              => $this->lang["DuyuruWisecp_button_renk_name"],
                'description'       => $this->lang["DuyuruWisecp_button_renk_description"],
                'type'              => "text",
                'value'             => isset($settings["DuyuruWisecp_button_renk"]) ? $settings["DuyuruWisecp_button_renk"] : "",
                'placeholder'       => "#000000",
            ],
			'DuyuruWisecp_button_renk_yazi'          => [
                'wrap_width'        => 100,
                'name'              => $this->lang["DuyuruWisecp_button_renk_yazi_name"],
                'description'       => $this->lang["DuyuruWisecp_button_renk_yazi_description"],
                'type'              => "text",
                'value'             => isset($settings["DuyuruWisecp_button_renk_yazi"]) ? $settings["DuyuruWisecp_button_renk_yazi"] : "",
                'placeholder'       => "#FFFFFF",
            ],
        ];
    }
    
    public function save_fields($fields=[]){
        if (!isset($fields['DuyuruWisecp_ust']) || !$fields['DuyuruWisecp_ust']) {
            $this->error = $this->lang["error1"];
            return false;
        }
        return $fields;
    }
    
    public function file_addHead(){
        $settings = isset($this->config['settings']) ? $this->config['settings'] : [];
        $durum = $this->config["status"];
        if ($durum) { ?>
        <link rel="stylesheet" href="https://<?=$_SERVER["SERVER_NAME"]?>/coremio/modules/Addons/DuyuruWisecp/css/duyuru-wisecp.min.css">
        <?php }
    }

    public function displayModal() {
        $settings = isset($this->config['settings']) ? $this->config['settings'] : [];
        $modalTitle = isset($settings["DuyuruWisecp_ust"]) ? $settings["DuyuruWisecp_ust"] : "Duyuru Başlığı";
        $modalImage = isset($settings["DuyuruWisecp_resim"]) ? $settings["DuyuruWisecp_resim"] : "";
        $modalText = isset($settings["DuyuruWisecp_metin"]) ? $settings["DuyuruWisecp_metin"] : "";
		$modalOran = isset($settings["DuyuruWisecp_oran"]) ? $settings["DuyuruWisecp_oran"] : "";
		$modalButtonArkaRenk = isset($settings["DuyuruWisecp_button_renk"]) ? $settings["DuyuruWisecp_button_renk"] : "";
		$modalButtonYaziRenk = isset($settings["DuyuruWisecp_button_renk_yazi"]) ? $settings["DuyuruWisecp_button_renk_yazi"] : "";
        $modalButtonLink = isset($settings["DuyuruWisecp_button"]) ? $settings["DuyuruWisecp_button"] : "#";
if (preg_match('/^%(\d+(\.\d+)?)/', $modalOran, $matches)) {
    $number = $matches[1];
    $percentSign = '%';
} else {
    $number = "0";
    $percentSign = ''; 
}
        ?>
<style>
.contentBox .content a
{
    display: inline-block;
    padding: 10px 20px;
    background: var(--skin-color);
    text-decoration: none;
    font-size: 1.5em;
    font-weight: 500;
    color: <?php echo htmlspecialchars($modalButtonYaziRenk); ?>;
	background:  <?php echo htmlspecialchars($modalButtonArkaRenk); ?>;
    margin-top: 15px;
    border-radius: 10px;
    
}
</style>
    <div class="popup">
        <div class="contentBox">
            <div class="close-modal">

            </div>
            <div class="imgBx">
               <a href="<?php echo htmlspecialchars($modalButtonLink); ?>" title="discount icons"> <img src="https://<?=$_SERVER["SERVER_NAME"]?>/coremio/modules/Addons/DuyuruWisecp/<?php echo htmlspecialchars($modalImage); ?>"></a>
            </div>
            <div class="content">
                <div>
                    <h1><?php echo htmlspecialchars($modalTitle); ?></h1>
                    <span class="ul1"></span>
                    <span class="ul2"></span>
                <h2><?php echo htmlspecialchars($number); ?><sup><?php echo htmlspecialchars($percentSign); ?></sup><span>İndirim</span></h2>
                <p><?php echo htmlspecialchars($modalText); ?></p>
                <a href="<?php echo htmlspecialchars($modalButtonLink); ?>">İncele</a>
                </div>
            </div>

        </div>
    </div>
   <script>
        const popup = document.querySelector('.popup');
        const close = document.querySelector('.close-modal');

        const popupDisplayedKey = 'popupDisplayed';
        const popupDisplayDuration = 1000 * 60 * 60;

        window.onload = function() {
            const lastDisplayed = localStorage.getItem(popupDisplayedKey);
            const now = new Date().getTime();

            if (!lastDisplayed || now - lastDisplayed > popupDisplayDuration) {
                setTimeout(function() {
                    popup.style.display = "flex";
                }, 1000);
            }
        }

        close.addEventListener('click', () => {
            popup.style.display = "none";
            localStorage.setItem(popupDisplayedKey, new Date().getTime());
        });
    </script>
        <?php
    }
}

Hook::add("ClientAreaHeadCSS", 1, [
    'class'     => "DuyuruWisecp",
    'method'    => "file_addHead",
]);

Hook::add("ClientAreaEndBody", 1, [
    'class'     => "DuyuruWisecp",
    'method'    => "displayModal",
]);
?>
