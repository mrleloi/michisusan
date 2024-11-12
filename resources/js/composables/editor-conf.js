import {
  SourceEditing,
  Bold,
  Italic,
  Mention,
  Paragraph,
  Essentials,
  Heading,
  Undo,
  Alignment,
  Link,
  Image,
  Table,
  Font
} from 'ckeditor5'

export const useEditorConf = () => {
  const editorConfig = {
    language: 'ja',
    plugins: [
      SourceEditing,
      Bold,
      Italic,
      Mention,
      Paragraph,
      Essentials,
      Heading,
      Undo,
      Alignment,
      Link,
      Font,
      Image,
      Table
    ],
    toolbar: {
      items: [
        'undo',
        'redo',
        '|',
        'bold',
        'italic',
        '|',
        'alignment:left',
        'alignment:center',
        'alignment:right',
        '|',
        'link',
        '|',
        'insertTable',
        '|',
        'heading',
        'fontFamily',
        'fontSize',
        'fontColor',
        'fontBackgroundColor',
        '|',
        'sourceEditing'
      ],
      shouldNotGroupWhenFull: true
    }
  }
  return { editorConfig }
}
