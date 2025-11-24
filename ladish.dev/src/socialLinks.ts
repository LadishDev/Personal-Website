// Central configuration for all social media links
// Edit this file to update social links across the entire site

export interface SocialLink {
  name: string;
  url: string;
  icon: string; // Name of the icon in SvgIcons component
  display?: boolean; // Set to false to hide a link without deleting it
}

export const socialLinks: SocialLink[] = [
  {
    name: 'Bluesky',
    url: 'https://bsky.app/profile/ladishdev.bsky.social',
    icon: 'bluesky',
    display: true
  },
  {
    name: 'GitHub',
    url: 'https://github.com/LadishDev',
    icon: 'github',
    display: true
  },
  {
    name: 'LinkedIn',
    url: 'https://www.linkedin.com/in/callum-ladish/',
    icon: 'linkedin',
    display: true
  }
];

// Filter to only show links marked for display
export const activeSocialLinks = socialLinks.filter(link => link.display !== false);

// Helper to get a specific social link by name
export const getSocialLink = (name: string): SocialLink | undefined => {
  return socialLinks.find(link => link.name.toLowerCase() === name.toLowerCase());
};
