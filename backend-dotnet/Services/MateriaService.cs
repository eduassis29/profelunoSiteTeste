using backend_dotnet.Data;
using backend_dotnet.Models;
using backend_dotnet.Services.Interfaces;
using Microsoft.EntityFrameworkCore;

namespace backend_dotnet.Services
{
    public class MateriaService : IMateriaService
    {
        private ProfelunoContext _context;
        public MateriaService(ProfelunoContext context)
        {
            _context = context; 
        }

        public async Task<IEnumerable<Materia>> RetornaTodasMateriasAsync()
        {
            return await _context.Materias.ToListAsync();
        }
        public async Task<bool> CadastrarMateria(Materia materia)
        {
            if(materia == null) return false;
            var nomeExistente = await _context.Materias.AnyAsync(x => x.NomeMateria == materia.NomeMateria);
            if(nomeExistente) return false;
            Materia newMateria = new Materia
            {
                NomeMateria = materia.NomeMateria,
                CreatedAt = DateTime.Now,
                UpdatedAt = DateTime.Now
            };
            await _context.Materias.AddAsync(newMateria);
            await _context.SaveChangesAsync();
            return true;
        }

        public async Task<Materia> RetornaMateriaPorIdAsync(int idMateria)
        {
            return await _context.Materias.FirstOrDefaultAsync(x => x.IdMateria == idMateria);
        }

         public async Task<Materia> RetornaMateriaPorNomeAsync(string nomeMateria)
        {
            return await _context.Materias.FirstOrDefaultAsync(x => x.NomeMateria.ToUpper().StartsWith(nomeMateria.ToUpper()));
        }

         public async Task<Materia> AtualizaMateriaAsync(Materia materia)
        {
            _context.Materias.Update(materia);
            await _context.SaveChangesAsync();
            return materia;
        }

        public async Task<bool> DeletarMateria(int idMateria)
        {
            var materia = await _context.Materias.FirstOrDefaultAsync(x => x.IdMateria == idMateria);
            if(materia == null) return false;

            _context.Materias.Remove(materia);
            await _context.SaveChangesAsync();
            return true;
        }
    }
}
