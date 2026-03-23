using backend_dotnet.Data;
using backend_dotnet.Models;
using backend_dotnet.Models.Requests;
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
            return await _context.Materias.AsNoTracking().ToListAsync();
        }

        public async Task<bool> CadastrarMateria(CadastrarMateriaRequest materia)
        {
            if(materia == null) return false;
            Materia newMateria = new Materia
            {
                NomeMateria = materia.NomeMateria,
                SituacaoMateria = materia.SituacaoMateria,
                CreatedAt = DateTime.Now,
            };
            await _context.Materias.AddAsync(newMateria);
            await _context.SaveChangesAsync();
            return true;
        }

        public async Task<Materia> RetornaMateriaPorIdAsync(int idMateria)
        {
            return await _context.Materias.AsNoTracking().FirstOrDefaultAsync(x => x.IdMateria == idMateria);
        }

         public async Task<Materia> RetornaMateriaPorNomeAsync(string nomeMateria)
        {
            return await _context.Materias.AsNoTracking().FirstOrDefaultAsync(x => x.NomeMateria.ToUpper().StartsWith(nomeMateria.ToUpper()));
        }

         public async Task<Materia> AtualizaMateriaAsync(AtualizarMateriaRequest materia)
        {
            var newMateria = await _context.Materias.FirstOrDefaultAsync(x => x.IdMateria == materia.IdMateria);

            newMateria.NomeMateria = materia.NomeMateria;
            newMateria.SituacaoMateria = materia.SituacaoMateria;
            newMateria.UpdatedAt = DateTime.Now;

            _context.Materias.Update(newMateria);
            await _context.SaveChangesAsync();
            return newMateria;
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
