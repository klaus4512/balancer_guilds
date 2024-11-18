import { Link } from '@inertiajs/react';
import ButtonLink from "@/Components/ButtonLink.jsx";

export default function Pagination({ pagination }) {
    return (
        <nav className="flex justify-between">
            <ButtonLink
                href={route('player.index', { page: pagination.current_page - 1 })}
                className={`px-3 py-1 ${pagination.current_page === 1 ? 'text-gray-500' : 'text-blue-500'}`}
                disabled={pagination.current_page === 1}
            >
                Anterior
            </ButtonLink>
            <span>Página {pagination.current_page} de {pagination.last_page}</span>
            <ButtonLink
                href={route('player.index', { page: pagination.current_page + 1 })}
                className={`px-3 py-1 ${pagination.current_page === pagination.last_page ? 'text-gray-500' : 'text-blue-500'}`}
                disabled={pagination.current_page === pagination.last_page}
            >
                {pagination.current_page === pagination.last_page}
                Próxima
            </ButtonLink>
        </nav>
    );
}
