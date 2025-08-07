import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface File {
    id: number;
    uploaded_file_id: number;
    filename: string;
    path: string;
    mime_type: string;
    size: number;
    processed: boolean;
}

export interface Publication {
    id: number;
    file_id: number;
    name: string;
    id_oficio: number;
    pub_name: string;
    art_type: number;
    pub_date: Date;
    art_class: string;
    art_category: string;
    art_size: number;
    art_notes: string;
    num_page: number;
    pdf_page: number;
    edition_number: number;
    highlight_type: string;
    highlight_priority: string;
    highlight: string;
    highlight_image: string;
    highlight_image_name: string;
    id_materia: number;
}

export type BreadcrumbItemType = BreadcrumbItem;
