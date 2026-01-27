# FERWABA Admin Panel - Quick Reference Guide

## 🚀 Getting Started

### Access the Admin Panel
1. Navigate to: `http://localhost/ferwaba/admin/login.php`
2. Enter your admin credentials
3. Click "SIGN IN"

### Default Credentials (if needed)
- Check with your SuperAdmin for credentials
- Passwords are hashed using SHA1

---

## 📋 Main Features

### 1. Dashboard
**URL**: `admin/dashboard.php`
- View system statistics
- Quick access to all management sections
- Real-time date and time display
- Welcome message with admin name

### 2. Teams Management
**URL**: `admin/teams.php`
- View all basketball teams
- Add new teams with logo upload
- Edit team information
- Delete teams (with confirmation)
- Filter by division and gender

### 3. Players Management
**URL**: `admin/players.php`
- Manage player roster
- Add player profiles with photos
- Assign players to teams
- Track player statistics
- View player details

### 4. Coaches Management
**URL**: `admin/coaches.php`
- Manage coaching staff
- Add coach profiles
- Assign coaches to teams
- Track coaching experience

### 5. Games Management
**URL**: `admin/games.php`
- Schedule new games
- Update game scores
- Track game status (Scheduled/Completed)
- Automatic standings calculation

### 6. Standings
**URL**: `admin/standings-list.php`
- View league standings
- Automatic calculation from game results
- Filter by division and gender
- Points system: Win=2pts, Loss=1pt

### 7. Playoffs
**URL**: `admin/playoffs.php`
- Manage playoff brackets
- Track playoff rounds
- Update playoff results

### 8. News Management
**URL**: `admin/news.php`
- Create news articles
- Upload featured images
- Publish/unpublish articles
- Manage news categories

### 9. Gallery
**URL**: `admin/gallery.php`
- Upload photos
- Organize by categories
- Add captions and descriptions
- Delete images

### 10. Shop Management
**URL**: `admin/shop.php`
- Add merchandise items
- Upload product images
- Set prices and stock
- Manage product categories

### 11. National Teams
**URL**: `admin/national-teams.php`
- Manage national team rosters
- Track national team players
- View statistics

### 12. Admin Users (SuperAdmin Only)
**URL**: `admin/admins.php`
- Add new admin users
- Set admin roles (Admin/SuperAdmin)
- Activate/deactivate accounts
- Reset passwords

---

## 🎨 Design Features

### Color Coding
- **Blue**: Primary actions, main navigation
- **Green**: Success states, active items
- **Yellow**: Highlights, active navigation
- **Red**: Delete actions, errors
- **Orange**: Games and schedules
- **Purple**: Coaches
- **Teal**: Gallery and media

### Status Badges
- **Active**: Green background
- **Inactive**: Red background
- **Pending**: Yellow background
- **Completed**: Blue background

### Icons Guide
- 🏠 Dashboard
- 👥 Teams
- 🏃 Players
- 👨‍🏫 Coaches
- 📅 Games
- 📊 Standings
- 🏆 Playoffs
- 📰 News
- 🖼️ Gallery
- 🛍️ Shop
- 🇷🇼 National Teams
- 🔐 Admins

---

## 💡 Tips & Best Practices

### Navigation
1. Use the sidebar for main navigation
2. Click the logo to return to dashboard
3. Active page is highlighted in yellow
4. Hover effects show available actions

### Data Entry
1. All required fields are marked
2. Upload images in JPG, PNG, or GIF format
3. Use descriptive names for better organization
4. Save frequently to avoid data loss

### Mobile Access
1. Tap the floating menu button (☰) to open sidebar
2. All features work on mobile devices
3. Tables scroll horizontally on small screens
4. Touch-friendly button sizes

### Security
1. Always logout when finished
2. Change password regularly
3. Don't share admin credentials
4. SuperAdmin can manage all users

---

## 🔧 Common Tasks

### Adding a New Team
1. Go to Teams Management
2. Click "Add Team" button
3. Fill in team details (name, division, gender, location)
4. Upload team logo (optional)
5. Click "Save Team"

### Scheduling a Game
1. Go to Games Management
2. Click "Add Game" button
3. Select home and away teams
4. Set date, time, and venue
5. Choose division and gender
6. Click "Save Game"

### Updating Game Scores
1. Go to Games Management
2. Find the game and click "Edit"
3. Enter home and away scores
4. Change status to "Completed"
5. Click "Update Game"
6. Standings update automatically!

### Publishing News
1. Go to News Management
2. Click "Add News" button
3. Enter title and content
4. Upload featured image
5. Set category
6. Click "Publish News"

### Adding Gallery Photos
1. Go to Gallery
2. Click "Add Photo" button
3. Upload image file
4. Add title and description
5. Select category
6. Click "Save Photo"

---

## 📱 Responsive Breakpoints

### Desktop (> 1024px)
- Full sidebar visible
- All features accessible
- Optimal viewing experience

### Tablet (768px - 1024px)
- Collapsed sidebar (icons only)
- Hover to see labels
- Touch-optimized

### Mobile (< 768px)
- Hidden sidebar
- Floating menu button
- Full-screen content
- Swipe-friendly tables

---

## ⚡ Keyboard Shortcuts

- **Esc**: Close modals/dialogs
- **Tab**: Navigate form fields
- **Enter**: Submit forms
- **Ctrl+S**: Save (in forms)

---

## 🆘 Troubleshooting

### Can't Login?
1. Check email and password
2. Ensure account is active
3. Contact SuperAdmin if locked out
4. Clear browser cache

### Images Not Uploading?
1. Check file size (max 5MB recommended)
2. Use JPG, PNG, or GIF format
3. Ensure proper file permissions
4. Check uploads folder exists

### Standings Not Updating?
1. Ensure game status is "Completed"
2. Verify scores are entered
3. Check team assignments
4. Refresh the page

### Page Not Loading?
1. Check internet connection
2. Clear browser cache
3. Try different browser
4. Contact technical support

---

## 📞 Support

### For Technical Issues
- Contact: IT Department
- Email: support@ferwaba.rw
- Phone: +250 XXX XXX XXX

### For Admin Access
- Contact: SuperAdmin
- Email: admin@ferwaba.rw

### For Feature Requests
- Submit through admin panel
- Email: feedback@ferwaba.rw

---

## 🔄 System Updates

### Version 2.0 (Current)
- ✅ Professional government design
- ✅ Rwanda national colors
- ✅ Enhanced mobile support
- ✅ Live clock display
- ✅ Improved navigation
- ✅ Better data tables
- ✅ Professional forms

### Upcoming Features
- 📧 Email notifications
- 📊 Advanced analytics
- 📱 Mobile app
- 🔔 Real-time alerts
- 📈 Performance tracking

---

## 📚 Additional Resources

### Documentation
- Full system documentation: `/docs`
- API documentation: `/api-docs`
- Database schema: `/database.sql`

### Training
- Video tutorials: Coming soon
- User manual: Available on request
- Live training sessions: Contact admin

---

**FERWABA Management System v2.0**  
*Rwanda Basketball Federation - Official Administrative Platform*  
*Powered by Rwanda Sports Technology*

---

## 🎯 Quick Links

- [Dashboard](admin/dashboard.php)
- [Teams](admin/teams.php)
- [Players](admin/players.php)
- [Games](admin/games.php)
- [News](admin/news.php)
- [Change Password](admin/change-password.php)
- [Logout](admin/logout.php)

---

**Last Updated**: January 27, 2026  
**Version**: 2.0  
**Support**: support@ferwaba.rw
