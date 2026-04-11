# 🚀 Deployment Guide - Jim Ruimt Op Website

## Pre-Deployment Checklist

### 1. Content Review ✍️
- [ ] All placeholder text replaced with real content
- [ ] Phone numbers updated: `06 1234 5678` → Real number
- [ ] Email addresses updated: `info@jimruimtop.nl` → Real email
- [ ] Business address verified
- [ ] KVK and BTW numbers added
- [ ] All images have descriptive alt text
- [ ] Spell check completed on all pages

### 2. Image Optimization 🖼️
```bash
# Recommended: Convert images to WebP format
# Use online tools or:
# - Squoosh.app (online)
# - ImageOptim (Mac)
# - TinyPNG (online)

# Target sizes:
# - Hero images: < 200KB
# - Logo: < 50KB
# - Other images: < 150KB
```

**Images to optimize:**
- `file_24---f1a3f6be-ff29-4eb4-9169-64c58267bf1c.jpg` (Hero background)
- `file_25---53b04ee2-5183-4b2a-88a1-877f480030a6.jpg` (Logo)
- `file_26---05787c6d-5a2f-4a29-a396-a37570acc71c.jpg` (Profile)

### 3. Create Favicon 🎨
Use a favicon generator (e.g., realfavicongenerator.net):
1. Upload logo image
2. Generate all sizes
3. Download and place in root directory:
   - `favicon.ico`
   - `favicon-16x16.png`
   - `favicon-32x32.png`
   - `apple-touch-icon.png`

### 4. Form Setup 📧

#### Option A: FormSpree (Easiest)
1. Sign up at formspree.io
2. Create a new form
3. Update form action in contact.html:
```html
<form action="https://formspree.io/f/YOUR_FORM_ID" method="POST">
```

#### Option B: EmailJS
1. Sign up at emailjs.com
2. Create email template
3. Add EmailJS script to contact.html
4. Update form submission handler

#### Option C: Custom Backend
- Set up PHP mail script or Node.js backend
- Configure SMTP settings
- Add spam protection

### 5. Analytics Setup 📊

#### Google Analytics 4
1. Create GA4 property at analytics.google.com
2. Get Measurement ID (G-XXXXXXXXXX)
3. Add to all HTML files before `</head>`:
```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>
```

#### Google Tag Manager (Optional)
1. Create container at tagmanager.google.com
2. Add GTM code to all pages
3. Configure tags, triggers, and variables

### 6. SEO Setup 🔍

#### Google Search Console
1. Verify ownership at search.google.com/search-console
2. Submit sitemap.xml
3. Request indexing for main pages

#### Google My Business
1. Create/claim business listing
2. Add photos, hours, services
3. Verify location
4. Link to website

---

## Deployment Options

### Option 1: Netlify (Recommended) ⚡

**Pros:** Free, automatic HTTPS, CDN, continuous deployment
**Best for:** Quick deployment, automatic updates from Git

#### Steps:
1. **Prepare Repository**
```bash
cd /home/ubuntu/Documents/Klanten\ webdesignerstudio/juimruimtop2
git add .
git commit -m "Ready for production deployment"
git push origin master
```

2. **Deploy to Netlify**
   - Go to netlify.com
   - Click "Add new site" → "Import an existing project"
   - Connect to GitHub
   - Select repository: `jimruimtop`
   - Build settings:
     - Build command: (leave empty)
     - Publish directory: `/`
   - Click "Deploy site"

3. **Configure Custom Domain**
   - Go to Site settings → Domain management
   - Add custom domain: `www.jimruimtop.nl`
   - Update DNS records at your domain registrar:
     ```
     Type: CNAME
     Name: www
     Value: [your-site].netlify.app
     ```

4. **Enable HTTPS**
   - Automatically enabled by Netlify
   - Force HTTPS redirect in Site settings

5. **Set up Form Notifications**
   - Go to Site settings → Forms
   - Enable form notifications
   - Add notification email

### Option 2: Vercel 🔷

**Pros:** Free, fast, excellent performance
**Best for:** Modern static sites

#### Steps:
1. Go to vercel.com
2. Import GitHub repository
3. Deploy automatically
4. Add custom domain in project settings
5. Configure DNS (similar to Netlify)

### Option 3: Traditional Hosting (cPanel/FTP) 🗄️

**Pros:** Full control, works with existing hosting
**Best for:** Clients with existing hosting plans

#### Steps:
1. **Prepare Files**
   - Rename `index-production.html` to `index.html`
   - Ensure all files are in root directory
   - Upload `.htaccess` file

2. **Upload via FTP**
   - Use FileZilla or similar FTP client
   - Connect to hosting server
   - Upload all files to `public_html` or `www` directory

3. **Configure Domain**
   - Point domain to hosting server
   - Wait for DNS propagation (up to 48 hours)

4. **Enable SSL**
   - Use Let's Encrypt (free) via cPanel
   - Or purchase SSL certificate
   - Force HTTPS in .htaccess

5. **Test Email Forms**
   - Configure PHP mail() function
   - Or use SMTP settings
   - Test form submissions

---

## Post-Deployment Tasks

### 1. Testing 🧪
- [ ] Test all pages load correctly
- [ ] Test all links work
- [ ] Test forms submit successfully
- [ ] Test on mobile devices
- [ ] Test on different browsers
- [ ] Check HTTPS is working
- [ ] Verify analytics tracking

### 2. Performance Check ⚡
Run tests at:
- PageSpeed Insights (pagespeed.web.dev)
- GTmetrix (gtmetrix.com)
- WebPageTest (webpagetest.org)

**Target Scores:**
- Performance: 90+
- Accessibility: 95+
- Best Practices: 95+
- SEO: 95+

### 3. SEO Submission 📈
- [ ] Submit sitemap to Google Search Console
- [ ] Submit to Bing Webmaster Tools
- [ ] Verify Google My Business listing
- [ ] Add business to local directories

### 4. Monitoring Setup 📊
- [ ] Set up Google Analytics goals
- [ ] Configure Search Console alerts
- [ ] Set up uptime monitoring (e.g., UptimeRobot)
- [ ] Enable error tracking

---

## Maintenance Schedule

### Weekly
- Check form submissions
- Review analytics data
- Check for broken links

### Monthly
- Update content if needed
- Review performance metrics
- Check security updates
- Backup website files

### Quarterly
- Review and update SEO
- Analyze user behavior
- Update images/content
- Performance optimization

---

## Troubleshooting

### Forms Not Working
1. Check form action URL
2. Verify email settings
3. Check spam folder
4. Test with different email addresses

### Images Not Loading
1. Check file paths (case-sensitive on Linux servers)
2. Verify file permissions (644 for files, 755 for directories)
3. Check image optimization didn't corrupt files

### HTTPS Not Working
1. Verify SSL certificate is installed
2. Check .htaccess redirect rules
3. Clear browser cache
4. Check mixed content warnings

### Slow Loading
1. Optimize images further
2. Enable caching
3. Use CDN
4. Minify CSS/JS

---

## Support Resources

- **Netlify Docs**: docs.netlify.com
- **Google Analytics**: support.google.com/analytics
- **Search Console**: support.google.com/webmasters
- **Tailwind CSS**: tailwindcss.com/docs

---

## Emergency Contacts

**Technical Issues:**
- Hosting support: [Your hosting provider]
- Domain registrar: [Your domain provider]

**Content Updates:**
- Developer: [Your contact info]

---

## Version History

- **v1.0.0** - Initial production release
- **Date**: April 2026
- **Status**: ✅ Ready for deployment

---

**Good luck with the launch! 🚀**
