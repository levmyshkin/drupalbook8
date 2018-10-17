<?php

namespace Drupal\drupalbook_youtube\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'drupalbook_youtube_thumbnail' formatter.
 *
 * @FieldFormatter(
 *   id = "drupalbook_youtube_thumbnail",
 *   module = "drupalbook_youtube",
 *   label = @Translation("Displays video thumbnail"),
 *   field_types = {
 *     "drupalbook_youtube"
 *   }
 * )
 */
class DrupalbookYoutubeThumbnailFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();

    foreach ($items as $delta => $item) {
      preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $item->value, $matches);

      if (!empty($matches)) {
        $content = '<a href="' . $item->value . '" target="_blank"><img src="http://img.youtube.com/vi/' . $matches[0] . '/0.jpg"></a>';
        $elements[$delta] = array(
          '#type' => 'html_tag',
          '#tag' => 'p',
          '#value' => $content,
        );
      }

    }

    return $elements;
  }

}
