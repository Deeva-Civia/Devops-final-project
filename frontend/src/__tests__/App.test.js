import { render, screen } from '@testing-library/react';
import App from '../App';

test('renders login page correctly', () => {
    render(<App />);

    const titleElement = screen.getByText(/Login to your account/i); 
    expect(titleElement).toBeInTheDocument();

    const buttonElement = screen.getByRole('button', { name: /Login/i });
    expect(buttonElement).toBeInTheDocument();
});