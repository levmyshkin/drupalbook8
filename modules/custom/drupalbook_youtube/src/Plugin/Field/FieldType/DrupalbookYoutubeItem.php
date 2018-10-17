<?php

namespace Drupal\drupalbook_youtube\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'drupalbook_youtube' field type.
 *
 * @FieldType(
 *   id = "drupalbook_youtube",
 *   label = @Translation("Embed Youtube video"),
 *   module = "drupalbook_youtube",
 *   description = @Translation("Output video from Youtube."),
 *   default_widget = "drupalbook_youtube",
 *   default_formatter = "drupalbook_youtube_thumbnail"
 * )
 */
class DrupalbookYoutubeItem extends FieldItemBase {
  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'value' => array(
          'type' => 'text',
          'size' => 'tiny',
          'not null' => FALSE,
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Youtube video URL'));

    return $properties;
  }

}
