# SharePoster

![WordPress Plugin Version](https://img.shields.io/badge/version-1.0.2-blue.svg)
![WordPress](https://img.shields.io/badge/wordpress-5.0%2B-blue.svg)
![PHP](https://img.shields.io/badge/php-7.2%2B-purple.svg)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)

Create beautiful, professional social media posters automatically from your WordPress posts with customizable designs.

## 📋 Description

SharePoster is a powerful WordPress plugin that transforms your blog posts into eye-catching social media posters. Perfect for sharing on Facebook, Instagram, Twitter, and other social platforms.

Whether you're a blogger, content marketer, or social media manager, SharePoster makes it easy to create professional-looking posters that drive engagement and traffic to your content.

## ✨ Features

### Core Features
- **🎨 Automatic Poster Generation** - Convert any WordPress post into a shareable poster
- **🎭 Customizable Design** - Full control over colors, fonts, and layout
- **🖼️ Background Images** - Upload custom backgrounds or use defaults
- **📸 Featured Image Support** - Automatically includes post featured images
- **📝 Rich Text Editor** - Edit heading text with formatting options and special characters
- **🏷️ Metadata Control** - Edit category/topic and date for poster headers (NEW!)
- **🎯 One-Click Download** - Download high-quality PNG posters instantly

### Customization Options
- **Text Styling**
  - Custom text colors with color picker
  - Background color customization
  - Font size adjustment (10-50px)
  - Line height control (10-70px)
  - Rich text formatting (bold, italic, underline, alignment)
  - Special characters support (©, ®, ™, €, and more)

- **Metadata Control** ✨ NEW
  - Editable Category/Topic field for poster header
  - Editable Date field for poster header
  - Real-time live preview of metadata changes
  - Persistent settings (save/reset functionality)

- **Layout Controls**
  - Heading position (top/bottom)
  - Featured image positioning (9 options)
  - Image zoom (10-500%)
  - Background image upload

- **Branding**
  - Custom website URL
  - Additional details text
  - Logo integration (uses WordPress custom logo)

### Integration
- **📌 Meta Box Integration** - Quick access from post editor sidebar
- **🔗 Multiple Access Points** - Available in main menu, settings, and tools
- **💾 Settings Management** - Save and reset settings with AJAX
- **🌍 Translation Ready** - Full internationalization support

## 📦 Installation

### Automatic Installation

1. Log in to your WordPress admin panel
2. Navigate to **Plugins > Add New**
3. Search for **"SharePoster"**
4. Click **"Install Now"** and then **"Activate"**

### Manual Installation

1. Download the plugin zip file from [releases](https://github.com/salimhossain/SharePoster/releases)
2. Log in to your WordPress admin panel
3. Navigate to **Plugins > Add New > Upload Plugin**
4. Choose the downloaded zip file and click **"Install Now"**
5. Activate the plugin

### From Source

```bash
# Clone the repository
git clone https://github.com/salimhossain/SharePoster.git

# Move to your WordPress plugins directory
mv SharePoster /path/to/wordpress/wp-content/plugins/shareposter

# Activate through WordPress admin or WP-CLI
wp plugin activate shareposter
```

## 🚀 Usage

### Quick Start

1. **Create or Edit a Post**
   - Go to your WordPress post editor
   - Look for the "SharePoster" meta box in the sidebar

2. **Generate Poster**
   - Click **"Get SharePoster Image"**
   - The poster generator will open with your post data

3. **Customize**
   - Adjust colors, fonts, and layout to your preference
   - Upload custom background or featured images
   - Preview changes in real-time

4. **Download**
   - Click **"Download Poster"**
   - Share on social media platforms

### Advanced Usage

#### Configure Default Settings

Navigate to **SharePoster** in your admin menu to set default values:

```php
// Default settings
'bg_image_url'    => 'path/to/background.png',
'website_url'     => 'yourdomain.com',
'image_position'  => 'center center',
'text_color'      => '#000000',
'title_position'  => 'top',
'details'         => '•••• Details in Comments ••••',
'post_category'   => 'Politics',
'post_date'       => 'January 10, 2026'
```

#### Access Points

The plugin is accessible from three locations:
- **Main Menu** → SharePoster
- **Settings** → SharePoster
- **Tools** → SharePoster

## 🛠️ Technical Details

### Requirements

- **WordPress:** 5.0 or higher
- **PHP:** 7.2 or higher
- **Browser:** Modern browser with HTML5 Canvas support

### Architecture

Built using the [WordPress Plugin Boilerplate](https://wppb.me/) with proper separation of concerns:

```
shareposter/
├── shareposter.php          # Main plugin file
├── uninstall.php              # Cleanup on uninstall
├── includes/                  # Core functionality
│   ├── class-shareposter.php
│   ├── class-shareposter-loader.php
│   ├── class-shareposter-i18n.php
│   ├── class-shareposter-activator.php
│   └── class-shareposter-deactivator.php
├── admin/                     # Admin-specific functionality
│   ├── class-shareposter-admin.php
│   ├── partials/
│   │   └── shareposter-admin-display.php
├── assets/                    # Shared assets
│   └── images/
│   ├── css/
│   │   └── shareposter-admin.css
│   └── js/
│       ├── shareposter-admin.js
│       └── html2canvas.min.js
└── languages/                 # Translation files
```

### Technologies

- **HTML5 Canvas** - Poster rendering
- **html2canvas** - Client-side screenshot library
- **WordPress Color Picker** - Color selection
- **WordPress Media Uploader** - Image uploads
- **AJAX** - Asynchronous settings management

## 🎯 Roadmap

- [ ] Multiple poster templates
- [ ] Social media size presets (Instagram, Facebook, Twitter)
- [ ] Batch poster generation
- [ ] Custom font upload support
- [ ] Gradient backgrounds
- [ ] Filter and effects
- [ ] Export as JPG/WebP
- [ ] Schedule poster creation
- [ ] Integration with social media APIs
- [ ] Analytics tracking

## 🤝 Contributing

Contributions are welcome! Here's how you can help:

1. **Fork the repository**
2. **Create a feature branch** (`git checkout -b feature/AmazingFeature`)
3. **Commit your changes** (`git commit -m 'Add some AmazingFeature'`)
4. **Push to the branch** (`git push origin feature/AmazingFeature`)
5. **Open a Pull Request**

### Development Setup

```bash
# Clone your fork
git clone https://github.com/YOUR-USERNAME/SharePoster.git

# Create a branch
cd SharePoster
git checkout -b feature/your-feature

# Make changes and test in WordPress environment

# Commit and push
git add .
git commit -m "Description of changes"
git push origin feature/your-feature
```

### Coding Standards

- Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)
- Use proper escaping and sanitization
- Document all functions and classes
- Write clean, readable code

## 📝 Changelog

### 1.0.1 - 2025-12-02

#### Fixed
- Text domain and file references for WordPress.org compliance
- Plugin structure and architecture
- Code quality and standards

#### Improved
- Better text editor toolbar organization
- Improved color controls with dedicated buttons
- Enhanced metadata field persistence (save/reset)
- Better support for special characters in content

#### Added ✨ NEW FEATURES
- Editable Category/Topic field for poster header metadata
- Editable Date field for poster header metadata
- Real-time live preview for all metadata field changes
- Special character (charmap) button to text editor toolbar
- Forecolor and background color buttons to text editor
- Enhanced TinyMCE configuration for better cross-site compatibility

### 1.0.0 - 2024-01-15

#### Added
- Initial release
- Automatic poster generation from posts
- Customizable backgrounds and colors
- Featured image support with positioning
- Typography controls (size, height, color)
- Rich text editor for headings
- Zoom controls for images
- Meta box integration in post editor
- AJAX settings management
- Translation ready infrastructure
- WordPress Plugin Boilerplate architecture

## 📄 License

This project is licensed under the GPL v2 or later - see the [LICENSE](LICENSE) file for details.

```
SharePoster - WordPress Social Media Poster Generator
Copyright (C) 2024 Salim Hossain

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
```

## 👤 Author

**Salim Hossain**

- GitHub: [@salimhossain](https://github.com/salimhossain)
- Website: [https://github.com/salimhossain](https://github.com/salimhossain)

## 🙏 Acknowledgments

- [WordPress Plugin Boilerplate](https://wppb.me/) - Plugin architecture
- [html2canvas](https://html2canvas.hertzen.com/) - Canvas rendering
- WordPress Community - Documentation and support

## 📞 Support

- **Issues:** [GitHub Issues](https://github.com/salimhossain/SharePoster/issues)
- **Documentation:** [Wiki](https://github.com/salimhossain/SharePoster/wiki)
- **Questions:** [Discussions](https://github.com/salimhossain/SharePoster/discussions)

## 🔒 Privacy

SharePoster does not collect or store any personal data. All poster generation happens locally in your browser. No data is sent to external servers.

---

**Made with ❤️ for the WordPress Community**

If you find this plugin helpful, please consider:
- ⭐ Starring the repository
- 🐛 Reporting bugs
- 💡 Suggesting new features
- 🔀 Contributing code
- 📢 Spreading the word