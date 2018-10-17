<?php

namespace Drupal\drupalbook_youtube\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'drupalbook_youtube_video' formatter.
 *
 * @FieldFormatter(
 *   id = "drupalbook_youtube_video",
 *   module = "drupalbook_youtube",
 *   label = @Translation("Displays Youtube video"),
 *   field_types = {
 *     "drupalbook_youtube"
 *   }
 * )
 */
class DrupalbookYoutubeVideoFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'width' => '600',
      'height' => '450',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements['width'] = array(
      '#type' => 'textfield',
      '#title' => t('Youtube video width'),
      '#default_value' => $this->getSetting('width'),
    );
    $elements['height'] = array(
      '#type' => 'textfield',
      '#title' => t('Youtube video height'),
      '#default_value' => $this->getSetting('height'),
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();
    $width = $this->getSetting('width');
    $height = $this->getSetting('height');

    foreach ($items as $delta => $item) {
      preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $item->value, $matches);

      if (!empty($matches)) {
        $elements[$delta] = array(
          '#theme' => 'drupalbook_youtube_video_formatter',
          '#width' => $width,
          '#height' => $height,
          '#video_id' => $matches[0],
        );
      }

    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $settings = $this->getSettings();

    if (!empty($settings['width']) && !empty($settings['height'])) {
      $summary[] = t('Video size: @width x @height', ['@width' => $settings['width'], '@height' => $settings['height']]);
    }
    else {
      $summary[] = t('Define video size');
    }

    return $summary;
  }

}
