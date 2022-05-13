export namespace Models {
  export interface Contact {
    id: number;
    name: string;
    phone: string;
    image?: string;
    created_at: string;
    updated_at: string;
  }
  export interface User {
    id: number;
    name: string;
    email: string;
  }
}
