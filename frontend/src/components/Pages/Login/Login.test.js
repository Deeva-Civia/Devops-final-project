import { render, screen } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import '@testing-library/jest-dom';
import LoginPage from './LoginPage';

jest.mock('react-router-dom', () => ({
    MemoryRouter: ({ children }) => <div>{children}</div>,
    useNavigate: () => jest.fn()
}), { virtual: true });

test('renders login page correctly with real component', () => {
    render(
        <MemoryRouter>
            <LoginPage />
        </MemoryRouter>
    );

    // Cari teks judul
    const titleElement = screen.getByText(/Login to your account/i); 
    expect(titleElement).toBeInTheDocument();

    // Cari tombol
    const buttonElement = screen.getByRole('button', { name: /Login/i });
    expect(buttonElement).toBeInTheDocument();
});