const { Component } = wp.element;

import { useEffect, useState, useRef } from "@wordpress/element";

function Html(props) {
  if (!props.warn) {
    return null;
  }
  const editorRef = useRef(null);

  var editorId = props.editorId
  var onChange = props.onChange
  var value = props.value


  useEffect(() => {
    // Initialize WordPress editor
    wp.editor.initialize(editorId, {
      tinymce: {
        toolbar1:
          "bold italic underline strikethrough | bullist numlist | blockquote hr wp_more | alignleft aligncenter alignright | link unlink | fullscreen | wp_adv",
        toolbar2:
          "formatselect alignjustify forecolor | pastetext removeformat charmap | outdent indent | undo redo | wp_help",
      },
      quicktags: true,
      mediaButtons: true,
    });

    // Wait for TinyMCE to load
    const setupEditor = () => {
      const instance = tinymce.get(editorId);
      if (instance) {
        editorRef.current = instance;

        if (value) {
          instance.setContent(value);
        }


        // Attach change event listener
        instance.on("change", () => {
          const content = instance.getContent();

          if (onChange) {
            onChange(content);
          }
        });
      }
    };

    // Use a slight delay to ensure the editor is ready
    const timer = setTimeout(setupEditor, 500);

    return () => {
      clearTimeout(timer);

      // Cleanup WordPress editor on unmount
      if (editorRef.current) {
        editorRef.current.destroy();
        editorRef.current = null;
      }
      wp.editor.remove(editorId);
    };
  }, []);




  return (
    <textarea
      id={editorId}
    />


  );
}

class WPEditor extends Component {
  constructor(props) {
    super(props);

    this.state = { showWarning: true };

    this.handleToggleClick = this.handleToggleClick.bind(this);
  }

  handleToggleClick() {
    this.setState((state) => ({
      showWarning: !state.showWarning,
    }));
  }

  render() {
    var {
      editorId,
      onChange,
      value,
    } = this.props;

    return (
      <Html
        value={value}
        editorId={editorId}
        onChange={onChange}
        warn={this.state.showWarning}
      />
    );
  }
}

export default WPEditor;
