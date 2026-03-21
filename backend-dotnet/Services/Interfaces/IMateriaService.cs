using backend_dotnet.Models;

namespace backend_dotnet.Services.Interfaces
{
    public interface IMateriaService
    {
        public Task<IEnumerable<Materia>> RetornaTodasMateriasAsync();
        public Task<Materia> RetornaMateriaPorIdAsync(int idMateria);
        public Task<Materia> RetornaMateriaPorNomeAsync(string nomeMateria);
        public Task<Materia> AtualizaMateriaAsync(Materia materia);
        public Task<bool> CadastrarMateria(Materia materia);
        public Task<bool> DeletarMateria(int idMateria);
    }
}
