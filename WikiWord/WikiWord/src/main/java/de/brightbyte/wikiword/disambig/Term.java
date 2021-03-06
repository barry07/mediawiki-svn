package de.brightbyte.wikiword.disambig;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import de.brightbyte.wikiword.model.TermReference;

public class Term implements TermReference {

	private final String term;
	private final double  weight;
	
	public Term(final String term) {
		this(term, 1);
	}
	
	public Term(final String term, final double weight) {
		this.term = term;
		this.weight = weight;
	}

	public String getTerm() {
		return term;
	}

	public double getWeight() {
		return weight;
	}

	public String toString() {
		return getTerm();
	}

	@Override
	public int hashCode() {
		final int PRIME = 31;
		int result = 1;
		result = PRIME * result + ((term == null) ? 0 : term.hashCode());
		return result;
	}

	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		final Term other = (Term) obj;
		if (term == null) {
			if (other.term != null)
				return false;
		} else if (!term.equals(other.term))
			return false;
		return true;
	}

	public static List<Term> asTerms(String... terms) {
		return asTerms(Arrays.asList(terms));
	}

	public static List<Term> asTerms(Iterable<String> terms) {
		List<Term> tt = new ArrayList<Term>();
		for (String t: terms) {
			tt.add(new Term(t));
		}
		
		return tt;
	}

}
