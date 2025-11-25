/**
 * SharePoster Admin JavaScript
 *
 * @package SharePoster
 * @since 1.0.0
 */

(function( $ ) {
    'use strict';

    $( document ).ready( function() {

        // Color picker initialization with live preview.
        $( '.swp-text-color' ).wpColorPicker( {
            change: function( event, ui ) {
                const color = ui.color.toString();
                $( '#swp-heading, .swp-meta, .swp-web-address' ).css( 'color', color );
            },
            clear: function() {
                $( '#swp-heading, .swp-meta, .swp-web-address' ).css( 'color', '#000000' );
            }
        } );

        // Get element references.
        const heading = document.getElementById( 'swp-heading' );
        const headingImg = document.getElementById( 'swp-pc-photo' );
        const posterWrapper = document.querySelector( '.swp-pc-photo' );

        // Function to update heading preview.
        function updateHeadingPreview() {
            if ( typeof tinymce !== 'undefined' && tinymce.get( 'heading_text' ) ) {
                const content = tinymce.get( 'heading_text' ).getContent();
                heading.innerHTML = content;
            }
        }

        // Wait for TinyMCE to be fully loaded.
        $( document ).on( 'tinymce-editor-init', function( event, editor ) {
            if ( editor.id === 'heading_text' ) {
                // Update on any content change.
                editor.on( 'keyup change paste input', function() {
                    updateHeadingPreview();
                } );

                // Initial update.
                updateHeadingPreview();
            }
        } );

        // Fallback: Check if TinyMCE is already loaded.
        setTimeout( function() {
            if ( typeof tinymce !== 'undefined' && tinymce.get( 'heading_text' ) ) {
                const editor = tinymce.get( 'heading_text' );

                editor.on( 'keyup change paste input', function() {
                    updateHeadingPreview();
                } );

                updateHeadingPreview();
            }
        }, 1000 );

        // Fallback for plain textarea (if TinyMCE fails to load).
        $( '#heading_text' ).on( 'input', function() {
            if ( ! tinymce.get( 'heading_text' ) ) {
                heading.innerHTML = $( this ).val();
            }
        } );

        // WordPress Media Uploader for Background Image.
        $( '#upload_bg_image' ).on( 'click', function( e ) {
            e.preventDefault();

            const customUploader = wp.media( {
                title: 'Select Background Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            } ).on( 'select', function() {
                const attachment = customUploader.state().get( 'selection' ).first().toJSON();
                $( '#bg_image_url' ).val( attachment.url );
                $( '#bg-preview-img' ).attr( 'src', attachment.url );
            } ).open();
        } );

        // WordPress Media Uploader for Featured Image.
        $( '#upload_featured_image' ).on( 'click', function( e ) {
            e.preventDefault();

            const customUploader = wp.media( {
                title: 'Select Featured Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            } ).on( 'select', function() {
                const attachment = customUploader.state().get( 'selection' ).first().toJSON();
                $( '#featured_image_url' ).val( attachment.url );
                $( '#swp-pc-photo' ).attr( 'src', attachment.url );
            } ).open();
        } );

        // Update details preview.
        $( '#details' ).on( 'input', function() {
            $( '.swp-learn-more' ).text( $( this ).val() );
        } );

        // Save All Settings Button.
        $( '#save_all_settings' ).on( 'click', function( e ) {
            e.preventDefault();
            const button = $( this );
            const originalText = button.html();

            button.html( '<span class="swp-icon-loading"></span>Saving...' ).prop( 'disabled', true );

            $.ajax( {
                url: shareposter_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'shareposter_save_settings',
                    nonce: shareposter_data.nonce,
                    bg_image_url: $( '#bg_image_url' ).val(),
                    website_url: $( '#website_url' ).val(),
                    image_position: $( '#swp-picture-position' ).val(),
                    text_color: $( '#text_color' ).val(),
                    title_position: $( '#swp-title-position' ).val(),
                    details: $( '#details' ).val()
                },
                success: function( response ) {
                    if ( response.success ) {
                        button.html( '<span class="swp-icon-check"></span>Saved!' ).removeClass( 'button-primary' ).addClass( 'button-success' );
                        setTimeout( function() {
                            button.html( originalText ).removeClass( 'button-success' ).addClass( 'button-primary' ).prop( 'disabled', false );
                        }, 2000 );

                        // Update preview.
                        $( '.swp-web-address' ).text( $( '#website_url' ).val() );
                        $( '.swp-learn-more' ).text( $( '#details' ).val() );
                    } else {
                        alert( 'Error saving settings: ' + ( response.data || 'Unknown error' ) );
                        button.html( originalText ).prop( 'disabled', false );
                    }
                },
                error: function( xhr, status, error ) {
                    alert( 'Error saving settings: ' + error );
                    button.html( originalText ).prop( 'disabled', false );
                }
            } );
        } );

        // Reset Settings Button.
        $( '#reset_settings' ).on( 'click', function( e ) {
            e.preventDefault();

            if ( ! confirm( 'Are you sure you want to reset all settings to default? This will remove all saved data.' ) ) {
                return;
            }

            const button = $( this );
            const originalText = button.html();

            button.html( '<span class="swp-icon-loading"></span>Resetting...' ).prop( 'disabled', true );

            $.ajax( {
                url: shareposter_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'shareposter_reset_settings',
                    nonce: shareposter_data.nonce
                },
                success: function( response ) {
                    if ( response.success ) {
                        // Update form fields with default values.
                        $( '#bg_image_url' ).val( response.data.bg_image_url );
                        $( '#website_url' ).val( response.data.website_url );
                        $( '#swp-picture-position' ).val( response.data.image_position );
                        $( '#text_color' ).val( response.data.text_color );
                        $( '#swp-title-position' ).val( response.data.title_position );
                        $( '#details' ).val( response.data.details );

                        // Update color picker.
                        $( '.swp-text-color' ).wpColorPicker( 'color', response.data.text_color );

                        // Update preview.
                        $( '#bg-preview-img' ).attr( 'src', response.data.bg_image_url );
                        $( '.swp-web-address' ).text( response.data.website_url );
                        $( '.swp-learn-more' ).text( response.data.details );
                        $( '#swp-pc-photo' ).css( 'object-position', response.data.image_position );
                        $( '#swp-heading' ).css( 'color', response.data.text_color );

                        // Update title position.
                        if ( response.data.title_position === 'bottom' ) {
                            $( '#swp-heading' ).removeClass( 'swp-order-0' ).addClass( 'swp-order-2' );
                            posterWrapper.classList.remove( 'swp-order-2' );
                            posterWrapper.classList.add( 'swp-order-0' );
                        } else {
                            $( '#swp-heading' ).removeClass( 'swp-order-2' ).addClass( 'swp-order-0' );
                            posterWrapper.classList.remove( 'swp-order-0' );
                            posterWrapper.classList.add( 'swp-order-2' );
                        }

                        button.html( '<span class="swp-icon-check"></span>Reset!' ).removeClass( 'button-secondary' ).addClass( 'button-success' );
                        setTimeout( function() {
                            button.html( originalText ).removeClass( 'button-success' ).addClass( 'button-secondary' ).prop( 'disabled', false );
                        }, 2000 );
                    } else {
                        alert( 'Error resetting settings: ' + ( response.data || 'Unknown error' ) );
                        button.html( originalText ).prop( 'disabled', false );
                    }
                },
                error: function( xhr, status, error ) {
                    alert( 'Error resetting settings: ' + error );
                    button.html( originalText ).prop( 'disabled', false );
                }
            } );
        } );

        // Adjust font size with slider.
        $( '#swpAdjustFontSize' ).on( 'input', function() {
            const value = $( this ).val();
            $( '#font_size_value' ).text( value );
            heading.style.fontSize = value + 'px';
        } );

        // Adjust line height with slider.
        $( '#swpAdjustLineHeight' ).on( 'input', function() {
            const value = $( this ).val();
            $( '#line_height_value' ).text( value );
            heading.style.lineHeight = value + 'px';
        } );

        // Adjust image zoom with slider.
        $( '#swp-adjust-image' ).on( 'input', function() {
            const value = $( this ).val();
            $( '#zoom_value' ).text( value );
            const scaleValue = value / 100;
            headingImg.style.transform = 'scale(' + scaleValue + ')';
        } );

        // Change image position.
        $( '#swp-picture-position' ).on( 'change', function() {
            const position = $( this ).val();
            headingImg.style.objectPosition = position;
        } );

        // Change title position - swap order classes between heading and image wrapper.
        $( '#swp-title-position' ).on( 'change', function() {
            const position = $( this ).val();
            if ( position === 'bottom' ) {
                $( '#swp-heading' ).removeClass( 'swp-order-0' ).addClass( 'swp-order-2' );
                posterWrapper.classList.remove( 'swp-order-2' );
                posterWrapper.classList.add( 'swp-order-0' );
            } else {
                $( '#swp-heading' ).removeClass( 'swp-order-2' ).addClass( 'swp-order-0' );
                posterWrapper.classList.remove( 'swp-order-0' );
                posterWrapper.classList.add( 'swp-order-2' );
            }
        } );

        // Update website URL preview.
        $( '#website_url' ).on( 'input', function() {
            $( '.swp-web-address' ).text( $( this ).val() );
        } );

    } );

})( jQuery );

/**
 * Capture and download function.
 *
 * @since 1.0.0
 */
async function captureAndDownload() {
    const element = document.getElementById( 'shareshap-card' );
    element.style.pointerEvents = 'none';

    // Convert all images to Base64 first.
    const images = element.getElementsByTagName( 'img' );

    await Promise.all( Array.from( images ).map( async ( img ) => {
        if ( ! img.src.startsWith( 'data:' ) ) {
            try {
                const response = await fetch( img.src );
                const blob = await response.blob();
                const reader = new FileReader();
                await new Promise( ( resolve ) => {
                    reader.onloadend = () => {
                        img.src = reader.result;
                        resolve();
                    };
                    reader.readAsDataURL( blob );
                } );
            } catch ( error ) {
                console.error( 'Error converting image:', error );
            }
        }
    } ) );

    // Ensure all images are loaded.
    await Promise.all( Array.from( images ).map( ( img ) =>
        img.complete ? Promise.resolve() : new Promise( ( resolve ) => {
            img.onload = resolve;
        } )
    ) );

    element.style.pointerEvents = '';

    html2canvas( element, {
        useCORS: true,
        allowTaint: false,
        backgroundColor: 'transparent',
        scale: 3,
    } ).then( ( canvas ) => {
        // Resize the canvas.
        const targetWidth = 1200;
        const targetHeight = 1200;
        const resizedCanvas = document.createElement( 'canvas' );
        resizedCanvas.width = targetWidth;
        resizedCanvas.height = targetHeight;

        const ctx = resizedCanvas.getContext( '2d' );
        ctx.drawImage( canvas, 0, 0, targetWidth, targetHeight );

        // Convert to JPEG with quality compression.
        const imageData = resizedCanvas.toDataURL( 'image/jpeg', 0.9 );
        const downloadLink = document.createElement( 'a' );
        const timestamp = new Date().getTime();
        downloadLink.href = imageData;
        downloadLink.download = 'SharePoster-' + timestamp + '.jpg';
        downloadLink.click();
    } ).catch( ( error ) => {
        console.error( 'Error generating image:', error );
        alert( 'Error generating poster. Please try again.' );
    } );
}