import { NavItem } from "@/types";
import { FolderGit, LayoutGrid } from 'lucide-vue-next';

export const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Publicações',
        href: '/publications',
        icon: LayoutGrid,
    },
    {
        title: 'Files',
        href: '/files',
        icon: LayoutGrid,
    },
];

export const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/guiwatanabe/desafio1',
        icon: FolderGit,
    }
];

export const rightNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/guiwatanabe/desafio1',
        icon: FolderGit,
    }
];