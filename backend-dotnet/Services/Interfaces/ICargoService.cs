using backend_dotnet.Models;
using backend_dotnet.Models.Requests;

namespace backend_dotnet.Services.Interfaces
{
    public interface ICargoService
    {
        public Task<IEnumerable<Cargo>> RetornaTodosCargosAsync();
        public Task<Cargo> RetornaCargoPorIdAsync(int idCargo);
        public Task<Cargo> RetornaCargoPorNomeAsync(string nomeCargo);
        public Task<Cargo> AtualizaCargoAsync(AtualizarCargoRequest cargo);
        public Task<bool> CadastrarCargo(CargoRequest cargo);
        public Task<bool> DeletarCargoAsync(int idCargo);
    }
}
